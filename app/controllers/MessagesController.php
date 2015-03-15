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
		//
	}

	public function getConversation($id)
	{
		//
	}

}