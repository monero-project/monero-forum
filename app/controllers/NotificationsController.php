<?php

use Carbon\Carbon;

class NotificationsController extends \BaseController
{

	public function getIndex()
	{
		$user = Auth::user();
		$notifications = $user->notifications()->orderBy('created_at', 'DESC')->paginate(20);

		//some black magic so that we can fire an event after the HTML is rendered.
		//will let us show that there indeed are new notifications.
		$view = View::make('notifications.index', compact('notifications'));

		$view = Response::make($view);

		$user->notifications()->where('is_new', 1)->update(['is_new' => 0]);

		return $view;
	}

	//shows the notifications count.
	public function getCount()
	{
		return Notification::unreadCount();
	}

}