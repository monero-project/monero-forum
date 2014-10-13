<?php

use Carbon\Carbon;

class BaseController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		//start events.
			
		if(Auth::check())
		{
			$user = Auth::user();	
				
			if (!$user->gpg_auth && Route::getCurrentRoute()->getPath() != 'gpg-auth' && !str_contains(Route::getCurrentRoute()->getPath() ,'keychain/message')  && $user->in_wot && $user->key_id)
			{
				$otcp = "forum.monero:".str_random(40)."\n";
				
				$key_id = $user->key_id;
				
				putenv("GNUPGHOME=/tmp");
				$gpg = new gnupg();
				$gpg->addencryptkey($user->fingerprint);
				$message = $gpg->encrypt($otcp);
				
				$userkey = new Key();
				$userkey->key_id = $key_id;
				$userkey->password = Hash::make($otcp);
				$userkey->message = $message;
				$userkey->save();
				
				
				header('Location: /gpg-auth');
			}
			
		    if ($user->remember_for && $user->remember_for != 0)
		    {
		    	$last_login = $user->last_login;
		    	$last_login = new Carbon($last_login);
			    $last_login->addMinutes($user->remember_for);
			    
			    if ($last_login->lt(Carbon::now()))
			    {
			    	$user->remember_for = NULL;
			    	$user->save();
			    	
				    Auth::logout();
				    Session::put('messages', array('Your session has expired. We have logged you out.'));
			    }
		    }		    
		}
		
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}
	

}
