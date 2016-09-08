<?php

use Carbon\Carbon;

class Post extends \Eloquent {

	protected $fillable = [
		'user_id',
		'thread_id',
		'body',
		'body_original',
		'parsed'
	];
	protected $softDelete = true;

	use SoftDeletingTrait;

	public function user() {
		return $this->belongsTo('User');
	}

	public function thread() {
		return $this->belongsTo('Thread');
	}

	public function parent() {
	    return $this->belongsTo('Post','parent_id');
	}

	public function children() {
	    return $this->hasMany('Post','parent_id');
	}

	public function votes() {
		return $this->hasMany('Vote');
	}

	public function flags() {
		return $this->hasMany('Flag');
	}

	public static function validate($input) {
		$rules = array(
		'thread_id'		=> 'required|exists:threads,id',
		'body'			=> 'required',
		'parent_id'   	=> 'exists:posts,id',
		'my_name'  => 'honeypot',
		'my_time'  => 'required|honeytime:5'
		);
		return Validator::make($input, $rules);
	}

	//Weight accessor

	public function getWeightAttribute($value)
    {
    	$weight = $value;

    	if (Auth::check())
    	{
    		//check if the poster is related to the logged in user in any way

	    	$ratings = Auth::user()->ratings();

			//check if poster is in L1 of trust.
			if ($ratings->where('rated_username', '=', $this->user->username)->first())
			{
				$weight += Config::get('app.l1_post_weight');
			}
			//check if poster is in L2 of trust.
			else {
				foreach ($ratings as $rating)
				{
					if ($rating->rated_user->ratings->where('rated_username', '=', $this->user->username)->first())
					{
						$weight += Config::get('app.l2_post_weight');
					}
					//check if poster is in L3 of trust.
					else
					{
						foreach ($rating->rated_user->ratings as $l3_rating)
						{
							if ($l3_rating->user->ratings->where('rated_username', '=', $this->user->username)->first())
								$weight += Config::get('app.l3_post_weight');
						}
					}
				}
			}

			//check if any of the voters are related to us in any way.

			$votes = $this->votes;

			if ($votes->count() > 0)
			{
				foreach ($votes as $vote)
				{
					//check L1 of votes.
					if ($ratings->where('rated_username', '=', $vote->user->username)->first())
					{
						$weight += Config::get('app.l1_vote_weight');
					}
					//check L2 of votes.
					else {
						foreach ($ratings as $rating)
						{
							if ($rating->rated_user->ratings->where('rated_username', '=', $vote->user->username)->first())
							{
								$weight += Config::get('app.l2_vote_weight');
							}
							//check L3 of votes.
							else
							{
								foreach ($rating->rated_user->ratings as $l3_rating)
								{
									if ($l3_rating->user->ratings->where('rated_username', '=', $vote->user->username)->first())
										$weight += Config::get('app.l3_vote_weight');
								}
							}
						}
					}
				}
			}

			return $weight;

		}
		else
		{
			return $weight;
		}

    }

    //Weight mutator

    public function setWeightAttribute($value)
    {

    	$weight = $value;

    	if (Auth::check())
    	{
    		//check if the poster is related to the logged in user in any way

	    	$ratings = Auth::user()->ratings();

			//check if poster is in L1 of trust.
			if ($ratings->where('rated_username', '=', $this->user->username)->first())
			{
				$weight -= Config::get('app.l1_post_weight');
			}
			//check if poster is in L2 of trust.
			else {
				foreach ($ratings as $rating)
				{
					if ($rating->rated_user->ratings->where('rated_username', '=', $this->user->username)->first())
					{
						$weight -= Config::get('app.l2_post_weight');
					}
					//check if poster is in L3 of trust.
					else
					{
						foreach ($rating->rated_user->ratings as $l3_rating)
						{
							if ($l3_rating->user->ratings->where('rated_username', '=', $this->user->username)->first())
								$weight -= Config::get('app.l3_post_weight');
						}
					}
				}
			}

			//check if any of the voters are related to us in any way.

			$votes = $this->votes;

			if ($votes->count() > 0)
			{
				foreach ($votes as $vote)
				{
					//check L1 of votes.
					if ($ratings->where('rated_username', '=', $vote->user->username)->first())
					{
						$weight -= Config::get('app.l1_vote_weight');
					}
					//check L2 of votes.
					else {
						foreach ($ratings as $rating)
						{
							if ($rating->rated_user->ratings->where('rated_username', '=', $vote->user->username)->first())
							{
								$weight -= Config::get('app.l2_vote_weight');
							}
							//check L3 of votes.
							else
							{
								foreach ($rating->rated_user->ratings as $l3_rating)
								{
									if ($l3_rating->user->ratings->where('rated_username', '=', $vote->user->username)->first())
										$weight -= Config::get('app.l3_vote_weight');
								}
							}
						}
					}
				}
			}

			//make sure weight doesn't go below minimum_weight
			if ($weight < Config::get('app.minimum_weight')) $weight = Config::get('app.minimum_weight');

			$this->attributes['weight'] = $weight;

		}
		else
		{
			//make sure weight doesn't go below minimum_weight
			if ($weight < Config::get('app.minimum_weight')) $weight = Config::get('app.minimum_weight');

			$this->attributes['weight'] = $weight;
		}
    }

	public function getBodyAttribute($value) {
		if($this->parsed)
		{
			return $value;
		}
		else
		{
			$this->body_original = $value;
			$parsed_body = Markdown::string($value);
			$this->body = $parsed_body;
			$this->parsed = 1;
			$this->save();
			return $parsed_body;
		}
	}

	public function getIsUnreadAttribute() {
		$post = $this;
		$unread = !$post->deleted_at
		&&
		Auth::check()
		&&
		ThreadView::where('user_id', Auth::user()->id)->where('thread_id', $post->thread->id)->first()
		&&
		$post->created_at > ThreadView::where('user_id', Auth::user()->id)->where('thread_id', $post->thread->id)->first()->updated_at;
		return $unread;
	}

	public function getIsHiddenAttribute() {
		$post = $this;
		$average = $post->thread->average_weight;
		$hidden = $post->weight < $average;
		return $hidden;
	}

	public static function userCanSubmit($user) {

		//get no. of users' posts created in the past app.posts_daily_limit_minutes if he registered in the past app.posts_total_days_limit days
		if (User::isNew(Auth::user(), Config::get('app.posts_total_days_limit'))) {

			$postNumber = Post::where('user_id', '=', $user->id)
			                   ->where('created_at', '>', Carbon::now()->subMinutes(Config::get('app.posts_daily_limit_minutes'))->toDateTimeString())
						       ->count();

			//check if posted within posts_daily_limit_minutes
			if ($postNumber == 0) return true; else return false;

	    } else {

			//if user not new then he is allowed to post
			return true;

		}

	}

}
