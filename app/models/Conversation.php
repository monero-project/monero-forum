<?php

class Conversation extends \Eloquent {
	protected $fillable = [
		'user_id',
		'receiver_id',
		'title',
		'read_at',
	];

	//convert dates to carbon objects.
	public function getDates()
	{
		return [
			'created_at',
			'updated_at',
			'read_at'
		];
	}

	public function user() {
		return $this->belongsTo('User');
	}

	public function receiver() {
		return $this->belongsTo('User', 'receiver_id', 'id');
	}

	public function messages() {
		return $this->hasMany('Message');
	}

	//validator

	public static function validate($input) {

		$rules = [
			'title'     => 'required',
			'body'      => 'required',
			'username'  => 'required',
		];

		return Validator::make($input, $rules);
	}
}