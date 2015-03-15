<?php

class Message extends \Eloquent {

	protected $fillable = [
		'body',
		'is_read',
		'conversation_id',
		'user_id'
	];

	public function conversation() {
		return $this->belongsTo('Conversation');
	}

	public function user() {
		return $this->belongsTo('User');
	}

}