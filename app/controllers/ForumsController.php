<?php

class ForumsController extends \BaseController {

	public function index($forum_id, $forum_slug)
	{
		$threads = Thread::where('forum_id', '=', $forum_id)->orWhere('moved', $forum_id)->whereNull('deleted_at')->orderBy('updated_at', 'DESC')->paginate(Config::get('app.threads_per_page'));
		$forum = Forum::findOrFail($forum_id);
		return View::make('content.forum', array('resource_id' => $forum_id,'threads' => $threads, 'forum' => $forum, 'title' => 'Monero | '.$forum->name));
	}

}
