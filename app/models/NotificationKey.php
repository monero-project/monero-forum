<?php

class NotificationKey extends \Eloquent {

	protected $fillable = [
		'user_id',
		'hash'
	];

	protected $table = 'notification_keys';

	public function user() {
		return $this->belongsTo('User');
	}

}