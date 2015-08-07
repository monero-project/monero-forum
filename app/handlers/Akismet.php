<?php

Post::created(function($post) {

	//Build user array

	$user['agent']  = $_SERVER['HTTP_USER_AGENT'];
	if (Request::header('X-Forwarded-For') != NULL) {
		$user['ip'] = Request::header('X-Forwarded-For');
	}
	else {
		$user['ip'] = Request::getClientIp();
	}
	$user['referrer'] = $_SERVER['HTTP_REFERER'];

	$check = akismet_post($post, $user);

	if($check != 'true') {
		$post->is_queued = true;
		$post->akismet = true;
	}

	if($post->is_queued) {
		$thread = $post->thread;
		$thread->is_queued = true;
		$thread->save();
	}

	Log::info('Post '.$post->id. 'checked. '.$check.' returned');

	$post->save();

});
//
//Thread::created(function($thread) {
//
//	//if post in queue
//	//queue up thread
//
//	$post = Post::find($thread->post_id);
//
//	if($post && $post->is_queued) {
//		$thread->is_queued = true;
//		$thread->save();
//	}
//});