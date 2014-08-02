<?php

class Post extends \Eloquent {
	protected $fillable = [];
	
	public function user() {
		return $this->belongsTo('User');
	}
	
	public function thread() {
		return $this->belongsTo('Thread');
	}
	
	public function parent()
	{
	    return $this->belongsTo('Post','parent_id');
	}
	
	public function children()
	{
	    return $this->hasMany('Post','parent_id');
	}
	
	public static function validate($input) {
		$rules = array(
		'thread_id'		=> 'required|exists:threads,id',
		'title'			=> 'required',
		'body'			=> 'required',
		'parent_id'   	=> 'exists:posts,id',
		);
		return Validator::make($input, $rules);
	}
}