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
		return !$this->is_new;
	}

	public static function unreadCount() {

		if(Auth::check()) {
			$user = Auth::user();
			$count = $user->notifications()->where('is_new', 1)->count();
		}
		else {
			$count = 0;
		}

		return $count;
	}

}