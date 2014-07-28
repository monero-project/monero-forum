<?php

class ForumsController extends \BaseController {

	public function index($forum_slug, $forum_id)
	{
		$threads = Thread::where('forum_id', '=', $forum_id)->orderBy('updated_at', 'DESC')->paginate(5);

		return View::make('content.forum', array('threads' => $threads, 'forum_id' => $forum_id, 'forum_slug' => $forum_slug));
	}

}
