<?php

class Post extends \Eloquent {
	protected $fillable = [
		'user_id',
		'thread_id',
		'body'
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
			
			$this->attributes['weight'] = $weight;
			
		}
		else
		{
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
//		return true;
		$post = $this;
		$unread = !$post->deleted_at
		&&
		Auth::check()
		&&
		ThreadView::where('user_id', Auth::user()->id)->where('thread_id', $post->thread->id)->first()
		&&
		$post->updated_at > ThreadView::where('user_id', Auth::user()->id)->where('thread_id', $post->thread->id)->first()->updated_at;
		return $unread;
	}

	public function getIsHiddenAttribute() {
		$post = $this;
		$hidden = $post->weight < Config::get('app.hidden_weight');
		return $hidden;
	}

//	public function getBodyAttribute($value)
//	{
//		return Markdown::string($value);
//	}


}