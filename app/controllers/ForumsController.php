<?php

class ForumsController extends \BaseController {

	public function index($forum_id, $forum_slug)
	{
		$threads = Thread::where('is_queued', false)
		                 ->where('forum_id', '=', $forum_id)
						 ->orWhere('moved', $forum_id)
						 ->whereNull('deleted_at')
						 ->orderBy('updated_at', 'DESC')
						 ->paginate(Config::get('app.threads_per_page'));
		$forum = Forum::findOrFail($forum_id);

		if(Auth::check()) {
			$queued = Thread::where('forum_id', $forum_id)->where('is_queued', true)->where('user_id', Auth::user()->id)->get();
		}
		else {
			$queued = false;
		}
		return View::make('forums.show', array('queued' => $queued, 'resource_id' => $forum_id,'threads' => $threads, 'forum' => $forum, 'title' => 'Monero | '.$forum->name));
	}

}
