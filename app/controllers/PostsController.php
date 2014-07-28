<?php

class PostsControlelr extends \BaseController {

	public function submit() {
		$validator = Post::validate(Input::all());
		if (!$validator->fails())
		{
			$post = new Post();
			$post->user_id = Auth::user()->id;
			$post->thread_id = Input::get('thread_id');
			$post->title = Input::get('title');
			$post->body = Input::get('body');
			
			if (Input::get('parent_id', false))
				$post->parent_id = Input::get('parent_id');
				
			$post->save();
			
			return View::make('content.post');
		}
		else
			return View::make('content.post', array('errors' => $validator->messages()->all()));
	}

}
