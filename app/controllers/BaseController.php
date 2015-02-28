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
