<?php

class UsersController extends BaseController {

	public function getGPGAuth() {
		return View::make('user.gpg_auth');
	}
	
	public function gpgAuth() {

		$key_id = Auth::user()->key_id;
				
		$key = Key::where('key_id', '=', $key_id)->orderBy('created_at', 'DESC')->firstOrFail();
		$hash = $key->password;	

		if (Hash::check(Input::get('otcp')."\n", $hash))
		{
			$user = Auth::user();
			$user->gpg_auth = 1;
			$user->save();	
		}
			
		return Redirect::to('/');
	}

	public function login() {
	
		$remember = false;
		
		if (Input::get('remember_me') == 'on') $remember = true;
			
		if (Auth::attempt(array('username' => Input::get('username'), 'password' => Input::get('password')), $remember))
		{
			$user = Auth::user();
			$user->last_login = new DateTime();
			
			if (!$user->confirmed)
			{
				Auth::logout();
				return View::make('user.login', array('errors' => array('Your account is inactive.')));
			}
			
			
			if (Input::get('remember_for') != NULL && Input::get('remember_for') != '') 
				$user->remember_for = Input::get('remember_for');
						
			$user->save();
			
			return Redirect::to(URL::previous());
		}
		else
		{
			return View::make('user.login', array('errors' => array('Wrong username or password')));
		}
	}

	public function register() {

		$validator = User::validate(Input::all());

		if (!$validator->fails()) {

			if (Input::get('wot_register')) {
				if (!Input::get('otcp'))
				{
					/*
					|
					|	This has the WoT checks disabled temporarily.
					|	Does not attempt to retrieve a key from the WoT database. Uses the field data instead.
					|
					*/
					
					//$key = GPG::find(Input::get('username'));
					$otcp = "forum.monero:".str_random(40)."\n"; //generate a random password of 40 chars.

					/*if ($key)
					{
						$key_id = $key->keyid;
					}
					else */
					if (Input::get('key'))
						{
							$key_id = Input::get('key');
						}
					else
						return View::make('user.register', array('errors' => array('Looks like you forgot to input the Key ID.')));
						
					//get public key and deal with errors.	
					$pubkey = get_pubkey($key_id); //app/libraries/lib.gpg.php
					if ($pubkey == -1)
						return View::make('user.register', array('errors' => array('The key you have provided does not exist!')));
					else if ($pubkey == -2)
						return View::make('user.register', array('errors' => array('The key format you have provided is wrong!')));
					else if ($pubkey == -3)
						return View::make('user.register', array('errors' => array('Looks like something went wrong with retrieving your key. Please try again later.')));

					putenv("GNUPGHOME=/tmp");
					$gpg = new gnupg();
					$gpg->addencryptkey($gpg->import($pubkey)['fingerprint']);
					$message = $gpg->encrypt($otcp);

					$oldKey = Key::where('key_id', '=', Input::get('key'))->orderBy('created_at')->first();

					if ($oldKey)
						$oldKey->delete();

					$userkey = new key();
					$userkey->key_id = $key_id;
					$userkey->password = Hash::make($otcp);
					$userkey->message = $message;
					$userkey->save();

					return View::make('user.auth', array('input' => Input::all(), 'keyid' => $key_id, 'message' => $message));
				}
				else if (Input::get('otcp'))
					{
						/*$key = GPG::find(Input::get('username'));

						if ($key)
						{
							$key_id = $key->keyid;
						}
						else 
						*/
						if (Input::get('key'))
							{
								$key_id = Input::get('key');
							}

						$key = Key::where('key_id', '=', $key_id)->orderBy('created_at')->first();

						$hash = $key->password;
						if (Hash::check(Input::get('otcp')."\n", $hash))
						{

							//get public key and deal with errors.	
							$pubkey = get_pubkey($key_id); //app/libraries/lib.gpg.php
							if ($pubkey == -1)
								return View::make('user.register', array('errors' => array('The key you have provided does not exist!')));
							else if ($pubkey == -2)
								return View::make('user.register', array('errors' => array('The key format you have provided is wrong!')));
							else if ($pubkey == -3)
								return View::make('user.register', array('errors' => array('Looks like something went wrong with retrieving your key. Please try again later.')));

							putenv("GNUPGHOME=/tmp");
							$gpg = new gnupg();

							$key->delete();
							$user = new User();
							$user->password = Hash::make(Input::get('password'));
							$user->username = Input::get('username');
							$user->email = Input::get('email');
							$user->in_wot = 1;
							$user->key_id = $key_id;
							$user->fingerprint = $gpg->import($pubkey)['fingerprint'];
							$user->confirmation_code = str_random(20);
							$user->save();
							$member = \Role::where('name', 'Member')->get()->first();
							$user->roles()->attach($member);
							$data = array('user' => $user);
							Mail::send('emails.auth.welcome', $data, function($message) use($user)
							{
							    $message->from(Config::get('app.from_email'), Config::get('app.from_name'));		
							    $message->to($user->email)->subject(Config::get('app.welcome_email_subject'));
							});
							foreach (Config::get('app.admins') as $config_admin)
							{
								if ($user->username == $config_admin)
								{
									$admin = \Role::where('name', 'Admin')->get()->first();
									$user->roles()->attach($admin);
								}
							}
							Auth::attempt(array('username' => Input::get('username'), 'password' => Input::get('password')), true);
							KeychainController::pullRatings(); //Pulls ratings from the OTC database on registering.
							Auth::logout();
							return Redirect::to('/?regSuccess')->with('messages', array('Registration complete. Please check your email and activate your account.'));
						}
						else
							return View::make('user.auth', array('input' => Input::all(), 'message' => $key->message, 'keyid' => $key_id, 'errors' => array('Wrong decrypted message.')));
					}

			}
			else {
					$user = new User();
					$user->password = Hash::make(Input::get('password'));
					$user->username = Input::get('username');
					$user->email = Input::get('email');
					$user->in_wot = 0;
					$user->confirmation_code = str_random(20);
					$user->save();
					$data = array('user' => $user);
					$member = \Role::where('name', 'Member')->get()->first();
					Mail::send('emails.auth.welcome', $data, function($message) use($user)
					{
					    $message->from(Config::get('app.from_email'), Config::get('app.from_name'));		
					    $message->to($user->email)->subject(Config::get('app.welcome_email_subject'));
					});

					$user->roles()->attach($member);
					foreach (Config::get('app.admins') as $config_admin)
					{
						if ($user->username == $config_admin)
						{
							$admin = \Role::where('name', 'Admin')->get()->first();
							$user->roles()->attach($admin);
						}
					}
					Auth::attempt(array('username' => Input::get('username'), 'password' => Input::get('password')), true);
					KeychainController::pullRatings(); //Pulls ratings from the OTC database on registering.
					Auth::logout();
					return Redirect::to('/')->with('messages', array('Registration complete. Please check your email and activate your account.'));
				}
			/*else {
				return View::make('user.register', array('errors' => array('The person with this username is already registered in the Web of Trust. Please try a different username.')));
			}*/
		}
		else {
			return View::make('user.register', array('errors' => $validator->messages()->all()));
		}

	}

	public function showLogin() {
		return View::make('user.login', array('title' => 'Monero | User Login'));
	}

	public function showRegister() {
		return View::make('user.register', array('title' => 'Monero | User Registration'));
	}

	public function logout() {
		Auth::logout();
		return Redirect::to('/');
	}

	public function profile($username) {
		$user = User::where('username', $username)->firstOrFail();
		$ratings = $user->rated()->orderBy('created_at', 'desc')->paginate(10);
		if ($user)
			return View::make('user.profile', array('user' => $user, 'ratings' => $ratings, 'title' => 'Monero | User &raquo; '.$user->username));
		else
			return View::make('errors.404');
	}
	
	public function self() {
		$user = Auth::user();
		$ratings = $user->rated()->orderBy('created_at', 'desc')->paginate(10);
		if ($user)
			return View::make('user.profile', array('user' => $user, 'self' => true, 'ratings' => $ratings, 'title' => 'Monero | User &raquo; '.$user->username));
		else
			return View::make('errors.404');
	}
	
	public function ratings($user_id, $rating_way, $rating_type) {
		$ratings_pp = Config::get('app.ratings_per_page');
		$user = User::findOrFail($user_id);
		if ($rating_way == 'received')
		{
			if ($rating_type == 'all')
				$ratings = $user->rated()->orderBy('created_at', 'desc')->paginate($ratings_pp);
			else if ($rating_type == 'negative')
				$ratings = $user->rated()->whereRaw('rating < 0')->orderBy('created_at', 'desc')->paginate($ratings_pp);
			else if ($rating_type == 'positive')
				$ratings = $user->rated()->whereRaw('rating > 0')->orderBy('created_at', 'desc')->paginate($ratings_pp);
			else $ratings = $user->rated()->orderBy('created_at', 'desc')->paginate($ratings_pp);
		}
		else
		{
			if ($rating_type == 'all')
				$ratings = $user->ratings()->orderBy('created_at', 'desc')->paginate($ratings_pp);
			else if ($rating_type == 'negative')
				$ratings = $user->ratings()->whereRaw('rating < 0')->orderBy('created_at', 'desc')->paginate($ratings_pp);
			else if ($rating_type == 'positive')
				$ratings = $user->ratings()->whereRaw('rating > 0')->orderBy('created_at', 'desc')->paginate($ratings_pp);
			else $ratings = $user->ratings()->orderBy('created_at', 'desc')->paginate($ratings_pp);
		}
		return View::make('user.ratings', array('ratings' => $ratings, 'user' => $user, 'title' => 'Monero | '.$user->username.' ratings'));
	}
	
	public function threads($user_id) {
		$per_page = Config::get('app.user_threads_per_page');
		
		$user = User::findOrFail($user_id);
		$threads = $user->threads()->paginate($per_page);
		
		return View::make('user.threads', array('threads' => $threads, 'user' => $user));
	}
	
	public function posts($user_id) {
		$per_page = Config::get('app.user_posts_per_page');
		
		$user = User::findOrFail($user_id);
		$posts = $user->posts()->paginate($per_page);
		
		return View::make('user.posts', array('posts' => $posts, 'user' => $user));
	}
	
	public function settings() {
		return View::make('user.settings', array('user' => Auth::user(), 'title' => 'Monero | User Settings'));
	}
	
	public function settingsSave() {
		
		$user = Auth::user();
		$errors = array();
		
		//update email if email field has been changed.
		if (Input::get('email') != $user->email)
		{
			$check_email = Validator::make(
				array('email' => Input::get('email')),
				array('email' => 'required|email|unique:users')
			);
			//check if email is valid.
			if (!$check_email->fails())
				$user->email = Input::get('email');
			else
				$errors[] = 'Wrong email format or already in use.';
		}
		
		//update Monero Address if not empty or null.
		if (Input::has('monero_address') && Input::get('monero_address') != '')
		{
			if (substr(Input::get('monero_address'), 0, 1) == 4 && strlen(Input::get('monero_address')) > 60)
				$user->monero_address = Input::get('monero_address');
			else
				$errors[] = 'Incorrect Monero address format!';
		}
			
		//update Website if not empty or null.
		if (Input::has('website') && Input::get('website') != '')
			$user->website = Input::get('website');
			
		//update email visibility if not empty or null.
		if (Input::has('email_public') && Input::get('email_public') == 'on')
			$user->email_public = 1;
		else
			$user->email_public = 0;
			
		//check if a password has been entered
		if (Input::has('password') && Input::get('password') != '')
		{
			$check_password = Validator::make(
				array(
					'password' => Input::get('password'),
					'password_confirmation' => Input::get('password_confirmation')
				),
				array(
					'password' => 'required|confirmed'
				)
			);
			if (!$check_password->fails())
				$user->password = Hash::make(Input::get('password'));
			else
				$errors[] = 'Password mistmatch.';
		}
		
		$user->save();
		
		if (sizeof($errors) > 0)
			return Redirect::to(URL::previous())->with('errors', $errors);
		else
			return Redirect::to(URL::previous())->with('messages', array('Profile successfully updated.'));
	}
	
	public function uploadProfile() {
			
			$user = Auth::user();
			
			$mime = Input::file('profile')->getMimeType();

			if (!($mime == "image/jpeg" || $mime == "image/png") || !Input::file('profile')->isValid()) {
				return Redirect::to('/user/settings')->with('errors', array('Wrong image type!'));
			} else {				
			
				//generate new filename
				$fileName = $user->username.time();
				
				//get the old file name and remove it.
				$oldfile = $user->profile_picture;
				
				if ($oldfile != 'no_picture.jpg')
				{
					@unlink('uploads/profile/'.$oldfile);
					@unlink('uploads/profile/small_'.$oldfile);
				}
				
				$extension = Input::file('profile')->getClientOriginalExtension();

				Input::file('profile')->move('uploads/profile', $fileName.".".$extension);
				Image::make('uploads/profile/'.$fileName.'.'.$extension)->resize(150, 150)->save('uploads/profile/'.$fileName.'.'.$extension);
				Image::make('uploads/profile/'.$fileName.'.'.$extension)->resize(24, 24)->save('uploads/profile/small_'.$fileName.'.'.$extension);

				$user->profile_picture = $fileName.".".$extension;
				$user->save();

				return Redirect::to('/user/settings')->with('messages', array('Picture uploaded!'));
			}
	}
	
	public function deleteProfile() {
		$user = Auth::user();
		
		//get the old file name and remove it.
		$oldfile = $user->profile_picture;
		
		if ($oldfile != 'no_picture.jpg')
		{
			@unlink('uploads/profile/'.$oldfile);
			@unlink('uploads/profile/small_'.$oldfile);
		}
		
		$user->profile_picture = 'no_picture.jpg';
		$user->save();
		
		return Redirect::to(URL::previous())->with('messages', array('Profile picture removed successfully!'));
	}
	
	public function getAddGPG() {
		return View::make('user.settings.add-key');
	}
	
	public function postAddGPGKey() {
		if (Input::has('key_id'))
		{
			$key_id = Input::get('key_id');
			
			$key_exists = User::where('key_id', $key_id)->first();
			if ($key_exists)
				return Redirect::to(URL::previous())->with('errors', array('The key already exists.'));
							
			//get public key and deal with errors.	
			$pubkey = get_pubkey($key_id); //app/libraries/lib.gpg.php
			if ($pubkey == -1)
				return Redirect::to(URL::previous())->with('errors', array('The key you have provided does not exist!'));
			else if ($pubkey == -2)
				return Redirect::to(URL::previous())->with('errors', array('The key format you have provided is wrong!'));
			else if ($pubkey == -3)
				return Redirect::to(URL::previous())->with('errors', array('Looks like something went wrong with retrieving your key. Please try again later.'));
				
			$otcp = "forum.monero:".str_random(40)."\n";
				
			putenv("GNUPGHOME=/tmp");
			$gpg = new gnupg();
			$fingerprint = $gpg->import($pubkey)['fingerprint'];
			$gpg->addencryptkey($fingerprint);
			$message = $gpg->encrypt($otcp);
	
			$oldKey = Key::where('key_id', '=', Input::get('key'))->orderBy('created_at')->first();
	
			if ($oldKey)
				$oldKey->delete();
				
			$userkey = new Key();
			$userkey->key_id = $key_id;
			$userkey->password = Hash::make($otcp);
			$userkey->message = $message;
			$userkey->save();
			
			return View::make('user.settings.decrypt-message', array('key_id' => $key_id, 'fingerprint' => $fingerprint));
		}
		else
			return Redirect::to(URL::previous())->with('errors', array('The Key ID is invalid.'));
	}
	
	public function postGPGDecrypt() {
		if (Input::has('otcp') && Input::has('key_id') && Input::has('fingerprint'))
		{
			$key_id = Input::get('key_id');
			$key = Key::where('key_id', '=', $key_id)->orderBy('created_at')->first();
			
			$key_exists = User::where('key_id', $key_id)->first();
			if ($key_exists)
				return Redirect::to(URL::previous())->with('errors', array('The key already exists.'));
			
			$hash = $key->password;
			if (Hash::check(Input::get('otcp')."\n", $hash))
			{
				$user = Auth::user();
				
				$user->in_wot = 1;
				$user->key_id = $key_id;
				$user->fingerprint = Input::get('fingerprint');
				
				$user->save();
				
				return Redirect::to('/user/settings')->with('messages', array('GPG key added successfully.'));
			}
		}
		else
			return Redirect::to(URL::previous())->with('errors', array('Looks like you have not entered all of the required data.'));
	}
	
	public function accountInactive() {
		return View::make('errors.confirmed');
	}
	
	public function getActivate($user_id ,$code) {
		if ($code == User::findOrFail($user_id)->confirmation_code)
		{
			$user = User::findOrFail($user_id);
			$user->confirmed = 1;
			$user->save();
			
			return Redirect::to('/')->with('messages', array('User activated successfully. You can now log in.'));
		}
		else {
			return Redirect::to('/')->with('messages', array('Wrong activation key.'));
		}
	}
	
	public function getResend($user_id) {
		$user = User::findOrFail($user_id);
		$data = array('user' => $user);
		Mail::send('emails.auth.welcome', $data, function($message) use($user)
		{
		    $message->from(Config::get('app.from_email'), Config::get('app.from_name'));		
		    $message->to($user->email)->subject(Config::get('app.welcome_email_subject'));
		});
	}
	
	public function getForgotPassword() {
		return View::make('user.password.remind');
	}
	
	public function postForgotPassword() {
		
		if (Input::has('email') && Input::get('email') != '')
			$email = Input::get('email');
		else
			return View::make('user.password.remind')->with('errors', array('Looks like you left the email field empty.'));
		
		$user = User::where('email', $email)->first();
		
		if ($user)
		{
			$recovery_token = str_random(62);
			
			$user->recovery_token = $recovery_token;
			$user->save();
			
			$data = array('user' =>	$user);
			
			Mail::send('emails.auth.recover', $data, function($message) use($user)
			{
			    $message->from(Config::get('app.from_email'), Config::get('app.from_name'));		
			    $message->to($user->email)->subject(Config::get('app.recovery_email_subject'));
			});
			
		}
		
		return Redirect::to(URL::previous())->with('messages', array('You should receive an email with the instructions on how to change your password shortly.'));
	}
	
	public function getChangePassword($user_id, $recovery_token) {
		$user = User::findOrFail($user_id);
		
		if($user->recovery_token == $recovery_token)
		{
			if ($user->in_wot)
			{
				$key_id = $user->key_id;
				
				$otcp = "forum.monero:".str_random(40)."\n";
					
				putenv("GNUPGHOME=/tmp");
				$gpg = new gnupg();
				$fingerprint = $user->fingerprint;
				$gpg->addencryptkey($fingerprint);
				$message = $gpg->encrypt($otcp);
		
				$oldKey = Key::where('key_id', '=', Input::get('key'))->orderBy('created_at')->first();
		
				if ($oldKey)
					$oldKey->delete();
					
				$userkey = new Key();
				$userkey->key_id = $key_id;
				$userkey->password = Hash::make($otcp);
				$userkey->message = $message;
				$userkey->save();
			}
			return View::make('user.password.change', array('user' => $user, 'recovery_token' => $recovery_token));
		}
		else
			return View::make('errors.404');
	}
	
	public function postChangePassword() {
		$recovery_token = Input::get('recovery_token');
		$user = User::findOrFail(Input::get('user_id'));
		
		$gpg_auth = true;
		
		if ($user->in_wot)
		{
			$otcp = Input::get('otcp');
			
			$key_id = $user->key_id;
			$key = Key::where('key_id', '=', $key_id)->orderBy('created_at', 'DESC')->first();
			
			$hash = $key->password;
			
			if (Hash::check($otcp."\n", $hash))
				$gpg_auth = true;
			else
				return Redirect::to(URL::previous())->with('errors', array('We could not confirm that you own this GPG key. Please try again.'));
		}
		
		if ($gpg_auth)
		{
			$password = Input::get('password');
			$password_c = Input::get('password_confirmation');
			
			if ($password = $password_c)
			{
				$user->password = Hash::make($password);
				$user->save();

				return Redirect::to('/')->with('messages', array('Password changed successfully. You can now log in!'));
			}
			else
				return Redirect::to(URL::previous())->with('errors', array('Looks like the passwords did not match!'));
		}
		
	}

}
