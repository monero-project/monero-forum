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

	Log::info('Post '.$post->id. 'checked. '.$check.' returned');

	$post->save();

});

Thread::saved(function($thread) {

	//Have to do this on-save because post id is only added to the thread once a post is created.
	//Meaning, the head cannot be retrieved on-create.

	Log::info('Thread created '.$thread->id);

	$head = $thread->head();
	if($head && $head->is_queued && !$thread->is_queued)
	{
		$thread->is_queued = true;
		$thread->save();
	}

});