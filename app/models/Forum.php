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
		return "http://".$_SERVER['HTTP_HOST']."/".$this->id."/".$this->slug();
	}
	
	public function latest_post() {
		$key = 'forum_latest_post_'.$this->id;
		//caching this, because it takes a fair bit if there are a lot of posts.
		$forum = $this;
		$post = Cache::tags(['forum_'.$forum->id])->remember($key, Config::get('app.cache_latest_details_for'), function() use ($forum)
				{
				    return DB::table('forums')
						->where('forums.id', '=', $forum->id)
						->join('threads', 'forums.id', '=', 'threads.forum_id')
						->join('posts', 'threads.id', '=', 'posts.thread_id')
						->whereNull('posts.deleted_at')
						->orderBy('posts.created_at', 'DESC')
						->first();
				});
		return $post;
	}
	
	public function thread_count() {
		$key = 'forum_thread_count'.$this->id;
		$forum = $this;
		$count = Cache::tags(['forum_'.$forum->id])->remember($key, Config::get('app.cache_latest_details_for'), function() use ($forum)
				{
				    return $forum->threads->count();
				});
		return $count;
	}
	
	public function reply_count() {
		$key = 'forum_reply_count_'.$this->id;
		//caching this, because it takes a fair bit if there are a lot of posts.
		$forum = $this;
		$count = Cache::tags(['forum_'.$forum->id])->remember($key, Config::get('app.cache_latest_details_for'), function() use ($forum)
				{
				    return DB::table('forums')
						->where('forums.id', '=', $forum->id)
						->join('threads', 'forums.id', '=', 'threads.forum_id')
						->join('posts', 'threads.id', '=', 'posts.thread_id')
						->whereNull('posts.deleted_at')
						->count();
				});
		$count = $count - $this->thread_count();
		return $count;
	}
	
	public function latest_thread() {
	
		$key = 'forum_latest_thread_'.$this->id;
		
		$forum = $this;
		
		$thread = Cache::tags(['forum_'.$forum->id])->remember($key, Config::get('app.cache_latest_details_for'), function() use ($forum)
				{
				return DB::table('forums')
						->where('forums.id', '=', $forum->id)
						->join('threads', 'forums.id', '=', 'threads.forum_id')
						->whereNull('threads.deleted_at')
						->orderBy('threads.updated_at', 'DESC')
						->first();
				});

		return $thread;
	}

	public function getNewPostsAttribute() {
		if (Auth::check())
		{
			$key = 'user_'.Auth::user()->id.'_forum_'.$this->id.'_new_threads';
			$forum = $this;
			$newPosts = Cache::tags(['forum_'.$forum->id])->remember($key, '1', function() use ($forum)
					{					  		
					  	return (
			                $forum->latest_post()
			                &&
			                $forum->latest_thread()
			                &&
			                ThreadView::where('user_id', Auth::user()->id)->where('thread_id', $forum->latest_thread()->id)->first()
						    &&
						    $forum->latest_post()->updated_at
						    >
						    ThreadView::where('user_id', Auth::user()->id)
							    ->where('thread_id', $forum->latest_thread()->id)
							    ->first()
							    ->updated_at
						);
				});
			return $newPosts;
		}
		else {
			return false;
		}
	}

	public function getUnreadPostsAttribute() {
		if (Auth::check())
		{
			$key = 'user_'.Auth::user()->id.'_forum_'.$this->id.'_unread_threads';
			$forum = $this;
			$unreadPosts = Cache::tags(['forum_'.$forum->id])->remember($key, '1', function() use ($forum)
					{
							$count = 0;
					  		
					  		foreach ($forum->threads as $thread)
					  		{
					  			if ($thread->new_posts)
					  			{
					  				$count++;
					  			}
					  		}

							return $count;
					});
			return $unreadPosts;
		}
		else {
			return 0;
		}
	}
	
}