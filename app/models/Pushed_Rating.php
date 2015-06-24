<?php

class Pushed_Rating extends \Eloquent {
	protected $fillable = [];
	
	protected $table = 'pushed_ratings';
	
	public function user() {
		return $this->belongsTo('User');
	}
	
}