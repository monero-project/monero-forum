<?php

class Message extends \Eloquent {

	public function receiver() {
		return $this->belongsTo('User', 'receiver_id', 'id');
	}

	public function sender() {
		return $this->belongsTo('User', 'sender_id', 'id');
	}

}