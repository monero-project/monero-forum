<?php

class OTC_User extends \Eloquent {
	protected $connection = 'wot_ratings';
	protected $table = 'users';
	protected $primaryKey = 'nick';
	public $timestamps = false;
	
	public function user() {
		return $this->belongsTo('User', 'username', 'nick');
	}
	
	public function ratings() {
		return $this->hasMany('Rating', 'rated_user_id', 'id');
	}
}