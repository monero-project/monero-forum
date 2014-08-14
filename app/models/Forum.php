<?php

class Forum extends \Eloquent {
	protected $fillable = [];
	
	public function category() {
		return $this->belongsTo('Category');
	}
	
	public function threads() {
		return $this->hasMany('Thread');
	}
	
	public function slug() {
		$slug = $this->name;	
		
		$slug = preg_replace('~[^\\pL\d]+~u', '-', $slug);
		$slug = trim($slug, '-');
		$slug = iconv('utf-8', 'us-ascii//TRANSLIT', $slug);
		$slug = strtolower($slug);
		$slug = preg_replace('~[^-\w]+~', '', $slug);
			
		if (empty($slug)) {
	    	return 'n-a';
		}
			
		return $slug;
	}
	
	public function permalink() {
		return "http://".$_SERVER['HTTP_HOST']."/".$this->slug()."/".$this->id;
	}
	
	public function latest_post() {
		$key = 'forum_latest_post_'.$this->id;
		//caching this, because it takes a fair bit if there are a lot of posts.
		$forum = $this;
		$post = Cache::remember($key, Config::get('app.cache_latest_details_for'), function() use ($forum)
				{
				    return DB::table('forums')
						->where('forums.id', '=', $forum->id)
						->join('threads', 'forums.id', '=', 'threads.forum_id')
						->join('posts', 'threads.id', '=', 'posts.thread_id')
						->orderBy('posts.created_at', 'DESC')
						->first();
				});
		return $post;
	}
	
	public function thread_count() {
		$key = 'forum_thread_count'.$this->id;
		$forum = $this;
		$count = Cache::remember($key, Config::get('app.cache_latest_details_for'), function() use ($forum)
				{
				    return $forum->threads->count();
				});
		return $count;
	}
	
	public function reply_count() {
		$key = 'forum_reply_count_'.$this->id;
		//caching this, because it takes a fair bit if there are a lot of posts.
		$forum = $this;
		$count = Cache::remember($key, Config::get('app.cache_latest_details_for'), function() use ($forum)
				{
				    return DB::table('forums')
						->where('forums.id', '=', $forum->id)
						->join('threads', 'forums.id', '=', 'threads.forum_id')
						->join('posts', 'threads.id', '=', 'posts.thread_id')
						->count();
				});
		return $count;
	}
	
}