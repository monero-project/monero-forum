<?php

class Access extends \Eloquent {

	protected $table = 'access_log';
	
	public function user() {
		return $this->belongsTo('User');
	}
	
}