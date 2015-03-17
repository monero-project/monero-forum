<?php

class Notification extends \Eloquent {
	protected $fillable = [
		'user_id',
		'subscription_id',
	];

	public function user() {
		return $this->belongsTo('User');
	}

	public function subscription() {
		return $this->belongsTo('Subscription');
	}

	public function is_read() {
		$user = Auth::user();

		if($user->notifications_read && $user->notifications_read->gte($this->created_at))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public static function unreadCount() {

		if(Auth::check()) {
			$user = Auth::user();
			$read_at = $user->notifications_read;
			$count = $user->notifications()->where('created_at', '>=', $read_at)->count();
		}
		else {
			$count = 0;
		}

		return $count;
	}

}