<?php

class MessagesController extends \BaseController {

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

	public function getUnread()
	{
		$user = Auth::user();
		$messages = $user->sent_messages;

		return View::make('messages.list', compact('messages'));
	}

	public function postSend()
	{
		$username = Input::get('username');
		$body = Input::get('body');
		$title = Input::get('title');

		//find user by username
		$user = User::where('username', $username)->firstOrFail();

		//TODO: check validation for conversation and message

		$conversation = Conversation::create([
			'title' => $title,
			'user_id'   => Auth::user()->id,
			'receiver_id'   => $user->id,
			'read_at'       => new DateTime(),
		]);

		$message = Message::create([
			'user_id'           => Auth::user()->id,
			'body'              => $body,
			'conversation_id'   => $conversation->id,
		]);

		Session::put('messages', ['Conversation started successfully!']);

		return Redirect::route('messages.index');
	}

	public function getConversation($id)
	{
		//
	}

}