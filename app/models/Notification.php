<?php

class Notification extends \Eloquent {

	protected $fillable = [
		'user_id',
		'object_id',
		'notification_type',
		'is_new'
	];

	public function user() {
		return $this->belongsTo('User');
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

	public function getObjectAttribute() {
		switch ($this->notification_type) {
			case 'subscription':
				return Subscription::find($this->object_id);
			case 'mention':
				return Post::find($this->object_id);
			default:
				return null;
		}
	}

}