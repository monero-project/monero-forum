<?php

class NotificationsController extends \BaseController
{

	public function getIndex()
	{
		$user = Auth::user();
		$notifications = $user->notifications()->orderBy('created_at', 'DESC')->paginate(20);

		//some black magic so that we can fire an event after the HTML is rendered.
		//will let us show that there indeed are new notifications.
		$view = View::make('notifications.index', compact('notifications'));

		$view = Response::make($view);

		$user->notifications()->where('is_new', 1)->update(['is_new' => 0]);

		return $view;
	}

	//shows the notifications count.
	public function getCount()
	{
		return Notification::unreadCount();
	}

	//show RSS feed
	public function getRss($key)
	{
		$hash = NotificationKey::where('hash', $key)->first();

		if ($hash) {
			$feed = Feed::make();

			//cache the feed for 1 minute
//			$feed->setCache(1, 'notifications_' . $hash->hash);
			if (!$feed->isCached()) {

				$notifications = $hash->user->notifications()->orderBy('created_at', 'DESC')->take(20)->get();

				$feed->title = $hash->user->username.' Notifications | Monero Forum';
				$feed->description = 'Monero Forum Notifications for '. $hash->user->username;
				$feed->logo = 'http://static.getmonero.org/images/logo.svg';
				$feed->link = route('notifications.rss', [$hash->hash]);
				$feed->setDateFormat('datetime'); // 'datetime', 'timestamp' or 'carbon'
				$feed->pubdate = $notifications[0]->created_at;
				$feed->lang = 'en';
				$feed->setShortening(true); // true or false
				$feed->setTextLimit(100); // maximum length of description text

				foreach ($notifications as $notification) {
					// set item's title, author, url, pubdate, description and content
					if($notification->notification_type == 'subscription')
					{
						$heading = 'The thread <a href="'.route('thread.short', [$notification->object->thread_id]).'">'.e($notification->object->thread->name).'</a> has new replies!';
						$author = null;
						$url = route('thread.short', [$notification->object->thread_id]);
						$date = $notification->created_at;
						$description = null;
						$content = 'yoyo';
					}
					else
					{
						$heading = 'You have been mentioned in <a href="'.route('thread.short', [$notification->object->thread_id]).'">'.e($notification->object->thread->name).'</a> by <a href="'.route('user.show', [$notification->object->user->username]).'">'.e($notification->object->user->username).'</a>';
						$author = e($notification->object->user->username);
						$url = route('thread.short', [$notification->object->thread_id]);
						$date = $notification->created_at;
						$description = null;
						$content = 'yo';
					}

					$feed->add($heading, $author, $url, $date, $description, $content);
				}
			}

			return $feed->render('atom');

		}

		App::abort(404);

	}

	public function getGenerate() {

		if(Auth::check())
		{
			$user = Auth::user();
			if($user->notification_key)
			{
				Session::put('errors', ['You already have a key!']);
			}
			else
			{
				//generate a loooong hash.
				$hash = Hash::make($user->username.$user->id.$user->created_at);
				NotificationKey::create([
					'user_id'       => $user->id,
					'hash'          => $hash
				]);
				Session::put('messages', ['Key generated successfully!']);
			}
			return Redirect::back();
		}

		App::abort(404);
	}
}