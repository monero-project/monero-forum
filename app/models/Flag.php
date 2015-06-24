<?php

class Flag extends \Eloquent {
	protected $fillable = [];
	
	public function user() {
		return $this->belongsTo('User');
	}
	
	public function post() {
		return $this->belongsTo('Post');
	}
	
	public static function validate($input) {
	
		$rules = array(
		'user_id' => 'exists:users,id',
		'post_id' => 'exists:posts,id',
		'comment' => 'required'
		);
		
		return Validator::make($input, $rules);
	}
}