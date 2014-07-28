<?php

class Post extends \Eloquent {
	protected $fillable = [];
	
	public function user() {
		return $this->belongsTo('User');
	}
	
	public function thread() {
		return $this->belongsTo('Thread');
	}
	
	public function validate($input) {
		$rules = array(
		'thead_id'		=> 'required|exists:threads,id',
		'user_id'		=> 'required|exists:users,id',
		'title'			=> 'required',
		'body'			=> 'required',
		'parent_id'   	=> 'exists:posts,id',
		);
		return Validator::make($rules, $input);
	}
}