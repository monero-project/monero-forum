<?php

use Carbon\Carbon;

class MessagesController extends \BaseController
{

	public function getIndex()
	{
		$user = Auth::user();

		$conversations = $user->conversations()->orderBy('created_at', 'DESC')->paginate(20);

		return View::make('messages.list', compact('conversations'));

	}

	public function getCreate()
	{
		if(Input::has('username'))
		{
			$username = Input::get('username');
		}
		else
		{
			$username = false;
		}
		return View::make('messages.create', compact('username'));
	}

	public function postSend()
	{
		$username = Input::get('username');
		$body = Input::get('body');
		$title = Input::get('title');

		$body = Markdown::string($body);

		//find user by username
		$user = User::where('username', $username)->first();
		if(!$user)
		{
			Session::put('errors', ['The user does not exist!']);
			return Redirect::back();
		}
		else if ($user->id == Auth::user()->id)
		{
			Session::put('errors', ['You cannot start a conversation with yourself!']);
			return Redirect::back();
		}

		$validator = Conversation::validate(Input::all());

		if (!$validator->fails()) {

			$conversation = Conversation::create([
				'title' => $title,
				'user_id' => Auth::user()->id,
				'receiver_id' => $user->id,
				'user_read_at' => new DateTime(),
			]);

			$pm = Message::create([
				'user_id' => Auth::user()->id,
				'body' => $body,
				'conversation_id' => $conversation->id,
				'body_parsed' => 1
			]);

			Event::fire('message.sent', array($pm));

			Session::put('messages', ['Conversation started successfully!']);
			return Redirect::route('messages.index');
		} else {
			Session::put('errors', $validator->messages()->all());
			return Redirect::back();
		}
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
				$conversation->user_read = 1;
			} else {
				$conversation->receiver_read_at = Carbon::now();
				$conversation->receiver_read = 1;
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

		$body = Markdown::string($body);

		if ($conversation->user_id == Auth::user()->id || $conversation->receiver_id == Auth::user()->id) {
			//validate the message
			$validator = Message::validate(Input::all());
			if (!$validator->fails()) {
				$pm = Message::create([
					'user_id' => Auth::user()->id,
					'body' => $body,
					'conversation_id' => $conversation_id,
					'body_parsed' => 1
				]);

				Event::fire('message.sent', array($pm));

				$is_sender = $conversation->user_id == Auth::user()->id;

				if ($is_sender) {
					$conversation->receiver_read = 0;
				}
				else {
					$conversation->user_read = 0;
				}

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

	public function emailReply() {
		//get email data from mailgun
		$data = Input::all();

		$from       = $data['sender'];
		$to         = $data['recipient'];
		$body       = $data['stripped-text'];

		$body  = rtrim($body, '>'); //remove trailing quote from email body.

		//get the user.
		$user = User::where('email', $from)->firstOrFail();

		$exp = "/conversation-(\d+)/";
		$str = $to;

		preg_match($exp, $str, $matches);

		if($matches) {
			$conversation_id = $matches[1];
			$conversation = Conversation::findOrFail($conversation_id);
			if($conversation->user->id == $user->id || $conversation->receiver->id == $user->id)
			{
				$validate = [
					'body'          =>  $data,
					'conversation'  =>  $conversation_id
				];

				$validator = Message::validate($validate);

				if (!$validator->fails()) {
					$pm = Message::create([
						'user_id' => $user->id,
						'body' => $body,
						'conversation_id' => $conversation_id,
						'body_parsed' => 1
					]);

					Event::fire('message.sent', array($pm));

					$is_sender = $conversation->user_id == $user->id;

					if ($is_sender) {
						$conversation->receiver_read = 0;
					} else {
						$conversation->user_read = 0;
					}

					//update the created_at timestamp and bump the convo
					//up the list.
					$conversation->created_at = Carbon::now();
					$conversation->save();
				}
			}
		}

	}

}