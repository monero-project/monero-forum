<?php

class ThreadsController extends \BaseController {
	
	//Display of a thread needs to be calculated individually.
	
	public function index($forum_slug, $forum_id, $thread_slug, $thread_id)
	{
		$posts_per_page = Config::get('app.thread_posts_per_page');
		
		$thread = Thread::findOrFail($thread_id);
		
		$posts = Post::where('thread_id', '=', $thread_id)->whereNull('parent_id')->where('id', '<>', $thread->post_id)->orderBy('decay', 'DESC')->paginate($posts_per_page);
		
		return View::make('content.thread', array('posts' => $posts, 'thread' => $thread));
		
		//if user, check cache thread, if not cached, then cache it and calculate each post score individually, return modified post object?
	}

}
