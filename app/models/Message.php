<?php

class Message extends \Eloquent {

	protected $fillable = [
		'body',
		'conversation_id',
		'user_id'
	];

	public function conversation() {
		return $this->belongsTo('Conversation');
	}

	public function user() {
		return $this->belongsTo('User');
	}

	public static function validate($input) {

		$rules = [
			'body'              => 'required',
			'conversation'   => 'required|exists:conversations,id',
		];

		return Validator::make($input, $rules);
	}

}