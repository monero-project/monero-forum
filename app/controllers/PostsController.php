<?php

class PostsControlelr extends \BaseController {

	public function submit() {
		$validator = Post::validate(Input::all());
		$post = new Post();
		$post->user_id = Auth::user()->id;
		$post
	}

}
