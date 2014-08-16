<?php

class ForumsController extends \BaseController {

	public function index($forum_slug, $forum_id)
	{
		$threads = Thread::where('forum_id', '=', $forum_id)->orderBy('updated_at', 'DESC')->paginate(Config::get('app.threads_per_page'));
		$forum = Forum::findOrFail($forum_id);
		return View::make('content.forum', array('threads' => $threads, 'forum' => $forum));
	}

}
