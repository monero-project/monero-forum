<?php

class Post extends \Eloquent {
	protected $fillable = [];
	
	public function user() {
		return $this->belongsTo('User');
	}
	
	public function thread() {
		return $this->belongsTo('Thread');
	}
	
	public function validate() {
		$rules = array(
		'thead_id'		=> 'required|exists:threads,id',
		'user_id'		=> 'required|exists:users,id',
		'name'			=> 'required',
		'body'			=> 'required',
		'post_id'   	=> 'exists:posts,id',
		'parent_id'   	=> 'exists:posts,id',
		);
	}
}