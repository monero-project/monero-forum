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

if (Auth::check()) {

	Post::created(function ($post) {

		$user = Auth::user();

		//check if the user wants to subscribe to this thread and he is not already subscribed
		$is_subscribed = $user->subscriptions()->where('thread_id', $post->thread_id)->first();

		if ($user->subscribe && !$is_subscribed) {
			Subscription::create([
				'user_id' => $user->id,
				'thread_id' => $post->thread_id
			]);
		}

		//notify all subscribers
		$subscriptions = $post->thread->subscriptions;
		foreach ($subscriptions as $subscription) {
			//check if the post is your own and you are subscribed to the thread
			//obviously don't send the notification
			if($post->user_id != $subscription->user_id) {
				//check if the notification has been popped previously (within 1 minute)
				$latest =
					Notification::where('user_id', $subscription->user_id)
					->where('subscription_id', $subscription->id)
					->orderBy('created_at', 'DESC')
					->first();
				if($latest && $latest->created_at->diffInMinutes() >= 1) {
					Notification::create([
						'user_id' => $subscription->user_id,
						'subscription_id' => $subscription->id
					]);
					//TODO: email the content of the thread to the person.
				}
				else {
					//bump the notification up.
					$latest->created_at = new DateTime();
					$latest->save();
				}
			}
		}

	});

	//remove all the associated notifications
	Subscription::deleting(function ($subscription) {
		foreach ($subscription->notifications as $notification)
		{
			$notification->delete();
		}
	});

}