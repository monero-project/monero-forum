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

}