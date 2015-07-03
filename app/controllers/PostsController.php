<?php

use Eddieh\Monero\Monero;

class PostsController extends \BaseController {
	
	public function getProxyImage() {
		if (Input::has('link'))
		{
			$url = urldecode(Input::get('link'));
			$image = file_get_contents($url);

			$file_info = new finfo(FILEINFO_MIME_TYPE);
			$mime_type = $file_info->buffer($image);

			//Intervention/image does not support .gif files all that well and only produces single-frame images.
			if($mime_type == 'image/gif')
			{
				return Response::make($image, 200, array('content-type' => 'image/gif'));
			}
			else {
				$image = Image::make($image);
				return $image->response();
			}
		}
		else
		{
			return false;
		}
	}
	
	public function submit() {

		$thread = Thread::findOrFail(Input::get('thread_id'));
		$forum = Forum::findOrFail($thread->forum->id);

		if($forum->lock == 2 && (!Auth::user()->hasRole('Admin')))
				return Redirect::to(URL::previous())->with('messages', array('You do not have permission to do this'));

		if(is_string(Input::get('submit')))
		{
			$validator = Post::validate(Input::all());

			$thread = Thread::findOrFail(Input::get('thread_id'));
			$thread_id = $thread->id;
			$thread_slug = $thread->slug();
			$forum_id = $thread->forum->id;
			$forum_slug = $thread->forum->slug();
			$posts = $thread->posts();

			if (!$validator->fails())
			{
				$post = new Post();
				$post->user_id = Auth::user()->id;
				$post->thread_id = Input::get('thread_id');
				$post->body = Markdown::string(Input::get('body'));
				$post->body_original = Input::get('body');
				$post->parsed = 1;
				$post->weight = Config::get('app.base_weight');

				if (Input::get('post_id', false))
				{
					$post->parent_id = Input::get('post_id');

					//add weight to parent.
					/*
					$parent_post = Post::find(Input::get('post_id'));
					$parent_post->weight += Config::get('app.reply_weight');
					$parent_post->save();
					*/
				}

				$thread->touch(); //update the updated_at value to bump the thread up.
				$thread->save();

				$post->save();

	            //nuke the cache for thread on new post.

	            $forum = Forum::findOrFail($thread->forum_id);

	            $key = 'forum_latest_post_'.$forum->id;

	            if (Cache::has($key)) {
	                Cache::forget($key);
	            }
	            else {
	                Cache::remember($key, Config::get('app.cache_latest_details_for'), function() use ($forum)
	                {
	                    return DB::table('forums')
	                        ->where('forums.id', '=', $forum->id)
	                        ->join('threads', 'forums.id', '=', 'threads.forum_id')
	                        ->join('posts', 'threads.id', '=', 'posts.thread_id')
	                        ->whereNull('posts.deleted_at')
	                        ->count();
	                });
	            }

				return Redirect::to($thread->permalink());
			}

			else
				return View::make('threads.show', array('errors' => $validator->messages()->all(), 'posts' => $posts, 'forum_id' => $forum_id, 'forum_slug' => $forum_slug, 'thread_id' => $thread_id, 'thread_slug' => $thread_slug));
		}
		else {
			return Redirect::to(URL::previous())->withInput()->with('preview', Markdown::string(Input::get('body')));
		}
	}

	public function delete($post_id) {
		$post = Post::findOrFail($post_id);

		if ($post->user_id == Auth::user()->id || Auth::user()->hasRole('Admin'))
		{
			$post->delete();
			return 'true';
		}
		else {
			return 'false';
		}

	}

	public function update() {
		if(is_string(Input::get('submit')))
		{
			$validator = Post::validate(Input::all());
	
			$thread = Thread::findOrFail(Input::get('thread_id'));
			$thread_id = $thread->id;
			$thread_slug = $thread->slug();
			$forum_id = $thread->forum->id;
			$forum_slug = $thread->forum->slug();
			$posts = $thread->posts();
	
			if (!$validator->fails())
			{
				$post = Post::findOrFail(Input::get('post_id'));

				$post->body = Markdown::string(Input::get('body'));
				$post->body_original = Input::get('body');
				$post->parsed = 1;
	
				$post->save();

				$rules = [
					'target' => 'required|numeric',
					'currency'  => 'required|string',
				];
				$funding_validator = Validator::make(Input::all(), $rules);

				$is_funding = in_array($post->thread->forum_id, Config::get('app.funding_forums'));

				//check if the thread has funding and if the edited post is head.
				if($post->thread->funding && $post->thread->head()->id == $post->id && !$funding_validator->fails())
				{
					$funding = $post->thread->funding;
					$funding->target = Input::get('target');
					$funding->currency = Input::get('currency');
					$funding->save();
				}
				else if ($post->thread->head()->id == $post->id && !$funding_validator->fails() && $is_funding)
				{
					Funding::create([
						'thread_id'     => $post->thread_id,
						'currency'      => Input::get('currency'),
						'target'        => Input::get('target'),
						'payment_id'    => Monero::generatePaymentID($thread_id)
					]);
				}
				else if ($post->thread->head()->id == $post->id && $funding_validator->fails() && $is_funding)
				{
					return Redirect::back()->withInput()->with('errors', $funding_validator->messages()->all());
				}
	
				return Redirect::to($thread->permalink());
			}
	
			else
				return View::make('threads.show', array('errors' => $validator->messages()->all(), 'posts' => $posts, 'forum_id' => $forum_id, 'forum_slug' => $forum_slug, 'thread_id' => $thread_id, 'thread_slug' => $thread_slug));
		}
		else {
			return Redirect::to(URL::previous())->withInput()->with('preview', Markdown::string(Input::get('body')));
		}
	}

	public function get($post_id) {
		$post = Post::find($post_id);
		if ($post)
			return $post->body_original;
		else
			return 'false';
	}

	//Standalone Pages

	public function getDeletePage($post_id) {

		$post = Post::findOrFail($post_id);
		$thread = $post->thread;

		if ($post->user_id == Auth::user()->id || Auth::user()->hasRole('Admin'))
		{
			$post->delete();
			return Redirect::to($thread->permalink());

		}
		else {
			return View::make('errors.permissions');
		}

	}

	public function getReplyPage($post_id) {
		
		$post = Post::findOrFail($post_id);
		$forum = $post->thread->forum;
		
		if($forum->lock == 2 && (!Auth::user()->hasRole('Admin')))
				return Redirect::to(URL::previous())->with('messages', array('You do not have permission to do this'));
			
		return View::make('posts.reply', array('post' => $post));
	}

	public function getUpdatePage($post_id) {
		$post = Post::findOrFail($post_id);
		if ($post->user_id == Auth::user()->id || Auth::user()->hasRole('Admin'))
		{
			return View::make('posts.update', array('post' => $post));
		}
		else {
			return View::make('errors.permissions');
		}
	}

	public function getReportPage($post_id, $page_number) {
		$post = Post::findOrFail($post_id);
		return View::make('posts.report', array('post' => $post, 'page_number' => $page_number));
	}
	
	public function postReport() {
		$validator = Flag::validate(Input::all());
		if (!$validator->fails())
		{
			$report = new Flag();
			$report->user_id = Auth::user()->id;
			$report->post_id = Input::get('post_id');
			$report->link 	 = Post::findOrFail(Input::get('post_id'))->thread->permalink()."?page=".Input::get('page')."&noscroll=1#post-".Input::get('post_id'); 
			$report->comment = Input::get('comment');
			$report->save();
			return Redirect::to(URL::previous())->with('messages', array('You have successfully reported this post!'));
		}
		else {
			return Redirect::to(URL::previous())->with('messages', array('You cannot report this post!'));
		}
	}

	//Refresh and Load More

	public function listPosts($thread_id, $posts_num) {
		$thread = Thread::find($thread_id);
		
		$posts_list = '';

		if(!$thread) //check if thread exists.
			return 'false';
			
		else if ($posts_num == 'all')
			$posts_list .= display_posts(NULL, $thread_id, 0);

		else if ($posts_num)
			$posts_list .= display_posts(NULL, $thread_id, 0, $posts_num);

		else
			$posts_list = 'false';

		return $posts_list;
	}

	public function kramdownParse()
	{
		if (Input::has('body')) {
			return Markdown::string(Input::get('body'));
		}
		else {
			return 0;
		}
	}

}