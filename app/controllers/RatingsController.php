<?php

class RatingsController extends \BaseController {

	/*
		Submit a rating or edit a rating that already exists.
	*/
	public function rate() {
		$rated_user = User::findOrFail(Input::get('user_id'));
		$rater_user = Auth::user();
		
		if (Input::get('rating') >= -10 && Input::get('rating') <= 10 && Input::get('rating') != 0)
		{
			//Check if the user has been rated previously
			$rating = Rating::whereRaw('rated_username = ? AND username = ?', array($rated_user->username, $rater_user->username))->first();
			
			if (!$rating)
			{
				$rating = new Rating();
				$rating->username = $rater_user->username;
				$rating->rated_username = $rated_user->username;
			}
									
			$rating->rating = Input::get('rating');
			$rating->notes = Input::get('notes');
			$rating->save();
			
			return Redirect::to(URL::previous());
		}
		else {
			return 'error';
		}
	}

}
