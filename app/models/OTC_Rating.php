<?php

class OTC_Rating extends \Eloquent {
	protected $connection = 'wot_ratings';
	protected $table = 'ratings';
	
	public function otc_user() {
		return $this->belongsTo('OTC_User', 'nick', 'username');
	}
	
	public function user() {
		return $this->otc_user()->user();
	}
}