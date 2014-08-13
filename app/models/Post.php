<?php

class Post extends \Eloquent {
	protected $fillable = [];
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
    	if (Auth::check())
    	{
	    	$ratings = Auth::user()->ratings();
						
			//check if poster is in L1 of trust.
			if ($ratings->where('rated_username', '=', $this->user->username)->first())
				return $value + Config::get('app.l1_weight');
			//check if poster is in L2 of trust.
			foreach ($ratings as $rating)
			{
				if ($rating->rated_user->ratings->where('rated_username', '=', $this->user->username)->first())
					return $value + Config::get('app.l2_weight');
			}
			
			return $value;
			
		}
		else
		{
			return $value;
		}
		
    }
    
    public function setWeightAttribute($value)
    {
	    if (Auth::check())
    	{
	    	$ratings = Auth::user()->ratings();
						
			//check if poster is in L1 of trust.
			if ($ratings->where('rated_username', '=', $this->user->username)->first())
				return $this->attributes['weight'] = $value - Config::get('app.l1_weight');
			//check if poster is in L2 of trust.
			foreach ($ratings as $rating)
			{
				if ($rating->rated_user->ratings->where('rated_username', '=', $this->user->username)->first())
				return $this->attributes['weight'] = $value - Config::get('app.l2_weight');
			}	
			
			return $this->attributes['weight'] = $value;		
		}
		else
		{
			return $this->attributes['weight'] = $value;
		}
    }
    
    
}