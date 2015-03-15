<?php

use Carbon\Carbon;

class MessagesController extends \BaseController
{

	public function getIndex()
	{
		$user = Auth::user();

		$conversations = $user->conversations()->paginate(20);

		return View::make('messages.list', compact('conversations'));

	}

	public function getCreate()
	{
		return View::make('messages.create');
	}

	public function postSend()
	{
		$username = Input::get('username');
		$body = Input::get('body');
		$title = Input::get('title');

		//find user by username
		$user = User::where('username', $username)->firstOrFail();

		$validator = Conversation::validate(Input::all());

		if (!$validator->fails()) {

			$conversation = Conversation::create([
				'title' => $title,
				'user_id' => Auth::user()->id,
				'receiver_id' => $user->id,
				'read_at' => new DateTime(),
			]);

			$message = Message::create([
				'user_id' => Auth::user()->id,
				'body' => $body,
				'conversation_id' => $conversation->id,
			]);

			Session::put('messages', ['Conversation started successfully!']);
		} else {
			Session::put('errors', $validator->messages()->all());
		}

		return Redirect::route('messages.index');
	}

	public function getConversation($id)
	{
		$conversation = Conversation::findOrFail($id);

		//check if the user is a participant of the conversation
		if ($conversation->user_id == Auth::user()->id || $conversation->receiver_id == Auth::user()->id) {
			//check whether the user is the sender

			$is_sender = $conversation->user_id == Auth::user()->id;

			if ($is_sender) {
				$conversation->user_read_at = Carbon::now();
			} else {
				$conversation->receiver_read_at = Carbon::now();
			}

			$conversation->save();

			$messages = $conversation->messages()->orderBy('created_at', 'DESC')->paginate(20);
			return View::make('messages.conversation', compact('conversation', 'messages'));
		} else {
			Session::put('errors', ['You don\'t have the permission to do this.']);
			return Redirect::back();
		}
	}

	public function postReply()
	{
		$conversation_id = Input::get('conversation');
		$conversation = Conversation::findOrFail($conversation_id);
		$body = Input::get('body');

		if ($conversation->user_id == Auth::user()->id || $conversation->receiver_id == Auth::user()->id) {
			//validate the message
			$validator = Message::validate(Input::all());
			if (!$validator->fails()) {
				Message::create([
					'user_id' => Auth::user()->id,
					'body' => $body,
					'conversation_id' => $conversation_id
				]);

				//update the created_at timestamp and bump the convo
				//up the list.
				$conversation->created_at = Carbon::now();
				$conversation->save();

				Session::put('messages', ['Reply sent successfully.']);
			} else {
				Session::put('errors', $validator->messages()->all());
			}

			return Redirect::route('messages.conversation', [$conversation_id]);
		} else {
			Session::put('errors', ['You don\'t have the permission to do this.']);
			return Redirect::back();
		}
	}

}