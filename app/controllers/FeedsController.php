<?php

class FeedsController extends BaseController {
	public function forumFeed($forum_id, $forum_slug) {
		$forum = Forum::findOrFail($forum_id);
		
		$feed = Feed::make();
		
		$feed->setCache(10, 'forum_feed_'.$forum_id);
		
	    if (!$feed->isCached())
	    {
		   
	       $feed->title = $forum->name;
	       $feed->description = $forum->description;
	       $feed->link = $forum->permalink().'/feed';
	       $feed->setDateFormat('datetime');
	       $feed->pubdate = $forum->latest_post()->created_at;
	       $feed->lang = 'en';
	       $feed->setShortening(true); // true or false
	       $feed->setTextLimit(100); // maximum length of description text
	
		   $threads = $forum->threads;
		   
		   foreach ($threads as $thread)
		   {		   		   		
				$feed->add(
					$thread->name, 
					$thread->user->username, 
					$thread->permalink(), 
					$thread->created_at, 
					$thread->post->body
				);
		   }
	
	    }
	    
	    return $feed->render('atom'); 		
	}
	
	public function threadFeed($forum_id, $forum_slug, $thread_id, $thread_slug) {
		$thread = Thread::findOrFail($thread_id);
		
		//create the feed.
		$feed = Feed::make();
		
		$feed->setCache(10, 'thread_feed_'.$thread_id);
		
	    if (!$feed->isCached())
	    {
		   
	       $feed->title = $thread->name;
	       $feed->description = $thread->post->body;
	       $feed->link = $thread->permalink().'/feed';
	       $feed->setDateFormat('datetime');
	       $feed->pubdate = $thread->created_at;
	       $feed->lang = 'en';
	       $feed->setShortening(true); // true or false
	       $feed->setTextLimit(200); // maximum length of description text
	
		   $posts = $thread->posts;
		   
		   foreach ($posts as $post)
		   {		   		   		
				$feed->add(
					'Post #'.$post->id, 
					$post->user->username, 
					$thread->permalink(), 
					$post->created_at, 
					$post->body
				);
		   }
	
	    }
	    
	    return $feed->render('atom'); 
	}
	
	public function userFeed($username) {
		$user = User::where('username', $username)->first();
		
		$feed = Feed::make();
		
		$feed->setCache(10, 'user_feed_'.$username);
		
	    if (!$feed->isCached())
	    {
		   $posts = $user->posts()->orderBy('created_at', 'DESC')->take(20);
		   
	       $feed->title = 'User '.$user->username.' feed';
	       $feed->link = URL::to('user'.$user->username.'/feed');
	       $feed->setDateFormat('datetime');
	       $feed->pubdate = $posts->first()->created_at;
	       $feed->lang = 'en';
	       $feed->setShortening(true); // true or false
	       $feed->setTextLimit(200); // maximum length of description text
	
		   $posts = $posts->get();
		   
		   foreach ($posts as $post)
		   {		   		   		
				$feed->add(
					$post->thread->name, 
					$user->username, 
					$post->thread->permalink(), 
					$post->created_at, 
					$post->body
				);
		   }
	
	    }
	    
	    return $feed->render('atom'); 
	}
}