<?php

class MentionHandler
{

	public $body_parsed;
	public $users = [];
	public $usernames;
	public $body_original;
	public $reply;

	public function handle($data)
	{
		$this->body_original = $data->body;

		$this->usernames = $this->getUsernames();
		count($this->usernames) > 0 && $this->users = User::whereIn('username', $this->usernames)->get();

		$this->replace();

		$data->body = $this->body_parsed;
		$data->save();

		//todo mail and notify.

		foreach ($this->users as $user) {
			if($user->mention_notifications) {
				$mail_data = [
					'body' => $data->body,
					'username' => $user->username,
					'mentioned_by' => $data->user->username,
					'title' => $data->thread->name,
					'thread_id' => $data->thread_id
				];

				Mail::queue('emails.mention', $mail_data, function ($message) use ($data, $user) {
					$message->from(Config::get('app.from_email'), Config::get('app.from_name'));
					$message->to($user->email)->subject('You have been mentioned by ' . $data->user->username);
				});
			}
		}
	}

	public function getUsernames()
	{
		preg_match_all("/(\S*)\@([^\r\n\s]*)/i", $this->body_original, $mentioned);
		$usernames = [];
		foreach ($mentioned[2] as $key => $username) {
			if ($mentioned[1][$key] || strlen($username) > 25) {
				continue;
			}
			$usernames[] = $username;
		}
		return array_unique($usernames);
	}

	public function replace()
	{
		$this->body_parsed = $this->body_original;

		foreach ($this->users as $user) {
			$search = '@' . $user->username;
			$place = '[' . $search . '](' . URL::route('user.show', [$user->username]) . ')';
			$this->body_parsed = str_replace($search, $place, $this->body_parsed);
		}
	}
}