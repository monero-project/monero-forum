<?php

class AkismetController extends \BaseController {

	function __construct() {
		if(!(Auth::check() && Auth::user()->hasRole('Admin')))
		{
			App::abort(404);
		}
	}

	//Delete post
	//Mark it as SPAM in Akismet
	public function spam($id) {
		$post = Post::findOrFail($id);

		//mark as spam in akismet.

		$comment['blog'] = "https://forum.getmonero.org/";
		$comment['user_ip'] = $post->ip;
		$comment['user_agent'] = $post->user_agent;
		$comment['referrer'] = $post->referrer;
		$comment['permalink'] = $post->thread->permalink();
		$comment['comment_type'] = "post";
		$comment['comment_author'] = $post->user->username;
		$comment['comment_author_email'] = $post->user->email;
		$comment['comment_content'] = $post->body_original;

		$key = Config::get('app.akismet_key');

		$type = 'submit-spam';

		fuspam($comment, $type, $key);

		//remove flags
		Flag::where('post_id', $post->id)->where('status', 0)->update(['status' => 2]);

		$thread = Thread::where('post_id', $post->id)->first();
		if($thread)
		{
			$thread->delete();
		}

		$post->delete();

		return Redirect::to('/admin');
	}

	//Approve post
	//Send back to Akismet as HAM
	public function ham($id) {

		$post = Post::findOrFail($id);

		$comment['blog'] = "https://forum.getmonero.org/";
		$comment['user_ip'] = $post->ip;
		$comment['user_agent'] = $post->user_agent;
		$comment['referrer'] = $post->referrer;
		$comment['permalink'] = $post->thread->permalink();
		$comment['comment_type'] = "post";
		$comment['comment_author'] = $post->user->username;
		$comment['comment_author_email'] = $post->user->email;
		$comment['comment_content'] = $post->body_original;

		$key = Config::get('app.akismet_key');

		$type = 'submit-ham';

		fuspam($comment, $type, $key);

		$thread = Thread::where('post_id', $post->id)->first();
		if($thread)
		{
			$thread->is_queued = false;
			$thread->save();
		}

		$post->is_queued = false;
		$post->save();

		return Redirect::to('/admin');
	}

	public function approve($id) {
		$post = Post::findOrFail($id);

		$post->is_queued    = false;
		$post->akismet      = false;

		$post->save();

		//remove flags
		Flag::where('post_id', $post->id)->where('status', 0)->update(['status' => 2]);

		$thread = Thread::where('post_id', $post->id)->first();
		if($thread)
		{
			$thread->is_queued = false;
			$thread->save();
		}

		return Redirect::to('/admin');
	}

	public function delete($id) {

		$post = Post::findOrFail($id);

		$thread = Thread::where('post_id', $post->id)->first();

		if($thread)
		{
			$thread->forceDelete();
		}

		$post->forceDelete();

		return Redirect::to('/admin');
	}
}