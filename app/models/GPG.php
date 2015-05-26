<?php

class GPG extends \Eloquent {

	protected $connection = 'wot_gpg';
	protected $table = 'users';
	protected $primaryKey = 'nick';
	
	public function user() {
		return $this->belongsTo('User', 'nick', 'username');
	}
	
}