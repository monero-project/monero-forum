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
	$bamwar = bamwar_post($post);

	if($check == 'true') {
		$post->is_queued = true;
		$post->akismet = true;
	}
	if($bamwar)
	{
		$post->is_queued = true;
	}

	$post->save();

});

Thread::saved(function($thread) {

	//Have to do this on-save because post id is only added to the thread once a post is created.
	//Meaning, the head cannot be retrieved on-create.

	$head = $thread->head();
	if($head && $head->is_queued && !$thread->is_queued)
	{
		$thread->is_queued = true;
		$thread->save();
	}

});