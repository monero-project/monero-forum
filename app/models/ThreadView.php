<?php

class ThreadView extends \Eloquent {
	protected $fillable = [];
	protected $table = 'thread_views';
	
	
	public function user() {
		return $this->belongsTo('User');
	}
	
	public function thread() {
		return $this->belongsTo('Thread');
	}
}