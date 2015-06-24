<?php

class Subscription extends \Eloquent {
	protected $fillable = [
		'user_id',
		'thread_id'
	];

	public function thread() {
		return $this->belongsTo('Thread');
	}

	public function user() {
		return $this->belongsTo('User');
	}

	public function notifications() {
		return $this->hasMany('Notification');
	}
}