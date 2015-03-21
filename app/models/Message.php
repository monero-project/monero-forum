<?php

class Message extends \Eloquent {

	protected $fillable = [
		'body',
		'conversation_id',
		'user_id'
	];

	public function conversation() {
		return $this->belongsTo('Conversation');
	}

	public function user() {
		return $this->belongsTo('User');
	}

	public static function validate($input) {

		$rules = [
			'body'              => 'required',
			'conversation'   => 'required|exists:conversations,id',
		];

		return Validator::make($input, $rules);
	}

	public static function unreadCount() {
		$user = Auth::user();

		$sent = Conversation::where('user_id', $user->id)->where('user_read', 0)->count();
		$received = Conversation::where('receiver_id', $user->id)->where('receiver_read', 0)->count();

		$count = $sent + $received;

		return $count;
	}

}