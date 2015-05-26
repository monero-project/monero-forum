<?php
/**
 * Created by PhpStorm.
 * User: Eddie
 * Date: 21/03/15
 * Time: 15:29
 *
 * This handler is used to punch holes in the cache so that on new posts some cache items get refreshed.
 */


Post::created(function($post)
{
	$thread = $post->thread;
	$forum = $post->thread->forum;

	Cache::tags(['thread_'.$thread->id, 'forum_'.$forum->id])->flush();
});