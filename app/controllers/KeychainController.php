<?php

class KeychainController extends \BaseController {


	/*
		Check if user exists in the current WoT.
		Returns true or false.
	*/
	public function exists($username)
	{
		$gpg = GPG::find($username);
		if($gpg)
			return 'true';
		else
			return 'false';
	}

	public function message($key_id)
	{
		$key = Key::where('key_id', '=', $key_id)->firstOrFail();
		return View::make('user.message', array('message' => $key->message));
	}

	public function users()
	{
		$users = User::where('in_wot', '=', 1)->get();

		foreach ($users as $user)
		{
			//Check if the person is not in the current database that we have.
			//Can use JSON to check this pre-pulling the database.
			if (!GPG::find($user->username))
			{
				//Data for the Ratings database
				$sync_user['ratings']['total_rating'] = 0;
				$sync_user['ratings']['created_at'] = strtotime($user->created_at);
				$sync_user['ratings']['pos_rating_recv_count'] = 0;
				$sync_user['ratings']['neg_rating_recv_count'] = 0;
				$sync_user['ratings']['pos_rating_sent_count'] = 0;
				$sync_user['ratings']['neg_rating_sent_count'] = 0;
				$sync_user['ratings']['nick'] = $user->username;
				$sync_user['ratings']['host'] = 'unaffiliated/'.$user->username;

				//Data for the GPG database
				$sync_user['gpg']['keyid'] = $user->key_id;
				$sync_user['gpg']['fingerprint'] = $user->fingerprint;
				$sync_user['gpg']['bitcoinaddress'] = NULL;
				$sync_user['gpg']['registered_at'] = strtotime($user->created_at);
				$sync_user['gpg']['nick'] = $user->username;
				$sync_user['gpg']['last_authed_at'] = strtotime($user->updated_at);
				$sync_user['gpg']['is_authed'] = 0;

				echo json_encode($sync_user);
			}
		}
	}

	public function action() {
		$user = GPG::find('testdude3');
		$user->delete();
	}

	public static function pullRatings() {
		$user = Auth::user();
		if ($user->in_wot) {
			$otc_user = OTC_User::find($user->username);
			
			if (!$otc_user)
				return 'true'; //return error if no ratings exist for that user.
			
			//get the ratings that are newer than the last pull we've made
			$ratings =  OTC_Rating::whereRaw('rated_user_id = ? OR rater_user_id = ? AND created_at >= ?', array($otc_user->id, $otc_user->id, strtotime($user->last_pull)))->get();
						
			if ($ratings)
			{
				foreach ($ratings as $rating)
				{
					//check if rating exists in the current database.
					$rating_exists = Rating::whereRaw('username = ? and rated_username = ? and created_at = ?',
						array(
							OTC_User::where('id', '=', $rating->rater_user_id)->first()->nick,
							OTC_User::where('id', '=', $rating->rated_user_id)->first()->nick,
							$rating->created_at
						))->first();
					if (!$rating_exists)
					{
						echo $rating_exists;
						$inserted_rating = new Rating();
						$inserted_rating->username = OTC_User::where('id', '=', $rating->rater_user_id)->first()->nick;
						$inserted_rating->rated_username = OTC_User::where('id', '=', $rating->rated_user_id)->first()->nick;
						$inserted_rating->created_at   		= 	$rating->created_at;
						$inserted_rating->rating    		= 	$rating->rating;
						$inserted_rating->notes    			= 	$rating->notes;
						$inserted_rating->save();
					}
				}

			}
			$user->last_pull = date('Y-m-d H:i:s');
			$user->save();
			return 'true';
		}
		else {
			return 'false';
		}
	}

	public function pushRatings() {
		$user = Auth::user();
		if (Input::get('signed_message', false) && $user->in_wot)
		{
			$push_rating = new Pushed_Rating();
			$push_rating->user_id = $user->id;
			$push_rating->signed_message = Input::get('signed_message');
			$push_rating->save();
			$user->last_push = date('Y-m-d H:i:s');
			$user->save(); 
			return 'true';
		}
		return 'false';
	}
	
	public function listRatings() {
		$ratings = Pushed_Rating::all();
		foreach ($ratings as $rating)
		{
			echo "<pre>".$rating->signed_message."</pre>";
		} 
	}
	
	public function myRatings() {
		$user = Auth::user();
		$ratings = $user->ratings()->where('created_at', '>=', $user->last_push)->get();
		if ($ratings && $user->in_wot)
		{
			$push_rating = array();
			foreach ($ratings as $key => $rating)
			{
				if (OTC_User::find($rating->rated_username)) {
					//check if rating exists in the current database. Laravel is unhappy if created_at is bound
						$rating_exists = OTC_Rating::whereRaw("rater_user_id = ? and rated_user_id = ? and created_at LIKE '%".strtotime($rating->created_at)."%'",
							array(
								OTC_User::find($rating->username)->id,
								OTC_User::find($rating->rated_username)->id
							))->get();
					if (OTC_User::find($rating->rated_username) && !$rating_exists)
					{
						$push_rating[$user->username][$key]['rated_user_id'] 	= OTC_User::find($rating->rated_username)->id;
						$push_rating[$user->username][$key]['rater_user_id'] 	= OTC_User::find($rating->username)->id;
						$push_rating[$user->username][$key]['created_at'] 		= strtotime($rating->created_at);
						$push_rating[$user->username][$key]['rating'] 			= $rating->rating;
						$push_rating[$user->username][$key]['notes'] 			= $rating->notes;
					}
				}
			}
			return json_encode($push_rating);
		}
		else
			return 'false';
	}
	
	public function downloadRatings() {
		$user = Auth::user();
		$ratings = $user->ratings()->where('created_at', '>=', $user->last_push)->get();
		if ($ratings && $user->in_wot)
		{
			$push_rating = array();
			foreach ($ratings as $key => $rating)
			{
				if (OTC_User::find($rating->rated_username)) {
					//check if rating exists in the current database. Laravel is unhappy if created_at is bound
						$rating_exists = OTC_Rating::whereRaw("rater_user_id = ? and rated_user_id = ? and created_at LIKE '%".strtotime($rating->created_at)."%'",
							array(
								OTC_User::find($rating->username)->id,
								OTC_User::find($rating->rated_username)->id
							))->get();
					if (OTC_User::find($rating->rated_username) && !$rating_exists)
					{
						$push_rating[$user->username][$key]['rated_user_id'] 	= OTC_User::find($rating->rated_username)->id;
						$push_rating[$user->username][$key]['rater_user_id'] 	= OTC_User::find($rating->username)->id;
						$push_rating[$user->username][$key]['created_at'] 		= strtotime($rating->created_at);
						$push_rating[$user->username][$key]['rating'] 			= $rating->rating;
						$push_rating[$user->username][$key]['notes'] 			= $rating->notes;
					}
				}
			}
			header('Content-disposition: attachment; filename=ratings.txt');
			header('Content-type: text/plain');
			echo json_encode($push_rating);
		}
		else
			return 'false';
	}

}