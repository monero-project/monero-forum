<?php

class SubscriptionsController extends \BaseController {

	public function getIndex() {
		if (Auth::check()) {
			$user = Auth::user();
			$subscriptions = $user->subscriptions()->orderBy('created_at', 'DESC')->paginate(20);

			return View::make('subscriptions.index', compact('subscriptions'));
		} else {
			return Redirect::to('/login');
		}
	}

	//delete subscription
	public function getUnsubscribe($id) {
		$user = Auth::user();
		$subscription = $user->subscriptions()->where('thread_id', $id)->first();

		if($subscription)
		{
			$subscription->delete();
			Session::put('messages', ['You have successfully unsubscribed from the thread.']);
		}
		else {
			Session::put('errors', ['You do not have an active subscription for ths thread.']);
		}

		return Redirect::back();
	}

	//subscribe to a thread
	public function getSubscribe($id) {

		$user = Auth::user();

		$thread = Thread::findOrFail($id); //just check whether the given thread exists or not.
		$subscription = $user->subscriptions()->where('thread_id', $id)->first();

		if(!$subscription)
		{
			Subscription::create([
				'user_id'   => $user->id,
				'thread_id' => $id,
			]);
			Session::put('messages', ['You have successfully subscribed to the thread.']);
		}
		else {
			Session::put('errors', ['You already have an active subscription for this thread.']);
		}

		return Redirect::back();

	}

	public function postSave() {

		$subscribe = Input::get('subscribe');
		$user = Auth::user();

		if($subscribe == 1) {
			$user->subscription = 1;
		}
		else {
			$user->subscription = 1;
		}

		$user->save();

		Session::put('messages', ['Your subscription settings have been saved.']);

		return Redirect::back();

	}

}
