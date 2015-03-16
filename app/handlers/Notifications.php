<?php
/**
 * Created by PhpStorm.
 * User: Eddie
 * Date: 16/03/15
 * Time: 17:53
 *
 * Handles notifications of users.
 *
 */

//Listens for when a post is created.

if(Auth::check()) {

	Post::created(function ($post) {

		//check if the user wants to subscribe to this thread and he is not already subscribed
		$is_subscribed = Auth::user()->subscriptions()->where('thread_id', $post->thread_id)->first();

		if(Auth::user()->subscribe && !$is_subscribed)
		{
			Subscription::create([
				'user_id'   => Auth::user()->id,
				'thread_id' => $post->thread_id
			]);
		}

		//notify all subscribers
		$subscriptions = $post->thread->subscriptions;
		foreach ($subscriptions as $subscription) {
			Notification::create([
				'user_id'           =>  Auth::user()->id,
				'subscription_id'   =>  $subscription->id
			]);
		}

	});

}