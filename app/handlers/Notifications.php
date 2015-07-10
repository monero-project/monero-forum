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

				$latest = Notification::where('user_id', $subscription->user_id)
					->where('object_id', $subscription->id)
					->where('notification_type', 'subscription')
					->orderBy('created_at', 'DESC')
					->first();
				//check if the first notification is the same notification, so that the notifications page does not blow up.
				if($latest && $latest->object->thread_id == $post->thread_id)
				{
					$latest->created_at = new DateTime();
					$latest->is_new	= 1;
					$latest->save();
				}
				//check if the notification has been popped previously (within 10 minutes)
				else if(($latest && $latest->created_at->diffInMinutes() >= 10) || !$latest) {
					Notification::create([
						'user_id' => $subscription->user_id,
						'object_id' => $subscription->id,
						'notification_type' => 'subscription',
						'is_new' => 1
					]);
					if($subscription->user->reply_notifications)
					{
						$data = array('post' => $post, 'user' => $subscription->user);
						Mail::send('emails.reply', $data, function ($message) use ($user, $post, $subscription) {
								$message->from(Config::get('app.from_email'), Config::get('app.from_name'));
								$message->to($subscription->user->email)->subject('New reply from '.$post->user->username.' in '.str_limit($post->thread->name, 30, '[...]'));
						});
					}
				}
				else if($latest) {
					//bump the notification up.
					$latest->created_at = new DateTime();
					$latest->is_new	= 1;
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

	//If the user is reading a thread and has any notifications, mark them as read.
	Event::listen('thread.read', function($thread)
	{
		$notifications = 

		DB::table('notifications')
		->leftJoin('subscriptions', 'subscriptions.id', '=', 'notifications.object_id')
		->leftJoin('users', 'users.id', '=', 'notifications.user_id')
		->where('users.id', Auth::user()->id)
		->where('notifications.notification_type', 'subscription');

		$notifications->update(['notifications.is_new' => 0]);

	});

	Message::created(function($pm) {

		Log::info('Checking user');

		$user = $pm->user;

		if ($user->id == $pm->conversation->receiver_id) {
			$sender = $pm->conversation->receiver;
			$receiver = $pm->conversation->user;
		} else {
			$sender = $pm->conversation->user;
			$receiver = $pm->conversation->receiver;
		}


		//check the user settings for reply notifications
		if ($receiver->reply_notifications) {
			Log::info('Reply notifications');
			$data = array(
				'pm' => $pm,
				'receiver' => $receiver,
				'sender' => $sender,
			);

			$conversation_id = $pm->conversation->id;

			Mail::send('emails.pm', $data, function ($message) use ($receiver, $pm, $sender, $conversation_id) {
				$message->from('conversation-' . $conversation_id . '@sandbox3c114f67499a4cecbda84350454e89fd.mailgun.org', Config::get('app.from_name'));
				$message->to($receiver->email)->subject('New message from ' . $sender->username . ' - ' . str_limit($pm->conversation->title, 30, '[...]'));
				Log::info('Mail sent');
			});
		}
	});

}