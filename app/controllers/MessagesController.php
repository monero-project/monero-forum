<?php

class MessagesController extends \BaseController {

	public function getIndex()
	{
		$user = Auth::user();
		$messages = $user->messages;

		return View::make('messages.index', compact('messages'));

	}

	public function getConversations()
	{
		$user = Auth::user();
		$messages = $user->sent_messages;

		return View::make('messages.conversations', compact('messages'));
	}

	public function getSent()
	{
		$user = Auth::user();
		$messages = $user->sent_messages;

		return View::make('messages.list', compact('messages'));
	}

	public function getReceived()
	{
		$user = Auth::user();
		$messages = $user->sent_messages;

		return View::make('messages.list', compact('messages'));
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

	public function getDestroy($id)
	{
		//
	}

}