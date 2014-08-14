<?php

class Vote extends \Eloquent {

	public function user() {
		return $this->belongsTo('User');
	}
	
	public function post() {
		return $this->belongsTo('Post');
	}
	
	public static function voted_insightful($post_id) {
		$vote = Vote::where('user_id', '=', Auth::user()->id)->where('post_id', '=', $post_id)->first();
		if (!$vote)
			return false;
		else if ($vote->vote == 1)
			return true;
		else
			return false;
	}
	
	public static function voted_irrelevant($post_id) {
		$vote = Vote::where('user_id', '=', Auth::user()->id)->where('post_id', '=', $post_id)->first();
		if (!$vote)
			return false;
		else if ($vote->vote == -1)
			return true;
		else
			return false;
	}

}