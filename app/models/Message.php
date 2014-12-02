<?php

class Message extends \Eloquent {

	public function receiver() {
		$this->belongsTo('User', 'receiver_id', 'user_id');
	}

	public function sender() {
		$this->belongsTo('User', 'sender_id', 'user_id');
	}

}