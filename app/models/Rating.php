<?php

class Rating extends \Eloquent {
	protected $fillable = [];
	
	public function user() {
		$this->belongsTo('User');
	}
	
	public function rated_user() {
		$this->belongsTo('User', 'rated_username', 'username');
	}
}