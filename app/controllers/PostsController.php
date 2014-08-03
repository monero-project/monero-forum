<?php

class PostsController extends \BaseController {

	public function submit() {
			
		$validator = Post::validate(Input::all());
		
		$thread = Thread::findOrFail(Input::get('thread_id'));
		$thread_id = $thread->id;
		$thread_slug = $thread->slug();
		$forum_id = $thread->forum->id;
		$forum_slug = $thread->forum->slug();
		$posts = $thread->posts();
		
		if (!$validator->fails())
		{
			$post = new Post();
			$post->user_id = Auth::user()->id;
			$post->thread_id = Input::get('thread_id');
			$post->title = Input::get('title');
			$post->body = Input::get('body');			
			
			if (Input::get('post_id', false))
				$post->parent_id = Input::get('post_id');
				
			$post->save();
			
			return Redirect::to($thread->permalink());
		}
		
		else
			return View::make('content.thread', array('errors' => $validator->messages()->all(), 'posts' => $posts, 'forum_id' => $forum_id, 'forum_slug' => $forum_slug, 'thread_id' => $thread_id, 'thread_slug' => $thread_slug));
	}
	
	public function delete($post_id) {
		$post = Post::findOrFail($post_id);
		
		if ($post->user_id == Auth::user()->id)
		{
			$post->delete();
			return 'true';	
		} 
		else {
			return 'false'; 
		}
		
	}
	
	public function update() {
		$validator = Post::validate(Input::all());
		
		$thread = Thread::findOrFail(Input::get('thread_id'));
		$thread_id = $thread->id;
		$thread_slug = $thread->slug();
		$forum_id = $thread->forum->id;
		$forum_slug = $thread->forum->slug();
		$posts = $thread->posts();
		
		if (!$validator->fails())
		{
			$post = Post::findOrFail(Input::get('post_id'));
			
			$post->title = Input::get('title');
			$post->body = Input::get('body');
				
			$post->save();
			
			return Redirect::to($thread->permalink());
		}
		
		else
			return View::make('content.thread', array('errors' => $validator->messages()->all(), 'posts' => $posts, 'forum_id' => $forum_id, 'forum_slug' => $forum_slug, 'thread_id' => $thread_id, 'thread_slug' => $thread_slug));
	}
	
	public function get($post_id) {
		$post = Post::find($post_id);
		if ($post)
			return $post->body;
		else
			return 'false';
	}

}
