<?php

class Trust extends \Eloquent {

	public function user() {
		return $this->belongsTo('User');
	}
	
	public function trusted_user() {
		return $this->belongsTo('User', 'trusted_user_id');
	}
	
}