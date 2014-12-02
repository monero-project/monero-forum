<?php

class ThreadsController extends \BaseController {
		
	public function index($forum_id, $forum_slug, $thread_id, $thread_slug)
	{
		$posts_per_page = Config::get('app.thread_posts_per_page');
		
		$thread = Thread::findOrFail($thread_id);

		//TODO: Sort by vote? 
		//check if sorting filter is being applied, if not, fallback to checking whether user has preferences set.
		if ((Input::has('sort')) || (Auth::check() && Auth::user()->default_sort != 'weight'))
		{
			
			if (Input::has('sort'))
				$sort = Input::get('sort');
			else
				$sort = Auth::user()->default_sort;

			switch ($sort) {
				case 'date_desc':
					$paginated = Post::withTrashed()->where('thread_id', '=', $thread->id)->where('id', '<>', $thread->post_id)->orderBy('created_at', 'DESC')->paginate($posts_per_page);
					$posts['list'] = $paginated->getItems();
					$posts['links'] = $paginated->appends(array('sort' => Input::get('sort')))->links();
					break;
				case 'date_asc':
					$paginated = Post::withTrashed()->where('thread_id', '=', $thread->id)->where('id', '<>', $thread->post_id)->orderBy('created_at', 'ASC')->paginate($posts_per_page);
					$posts['list'] = $paginated->getItems();
					$posts['links'] = $paginated->appends(array('sort' => Input::get('sort')))->links();
					break;
				case 'weight':
					//if user is authenticated, cache the query
					if (Auth::check())
					{
						$cache_key = 'user_'.Auth::user()->id.'_thread_'.$thread->id.'_page_'.Input::get('page', 1);
						$posts = Cache::remember($cache_key, Config::get('app.cache_posts_for'), function() use ($thread, $posts_per_page)
						{	
							$temp_posts = Post::withTrashed()->where('thread_id', '=', $thread->id)->whereNull('parent_id')->where('id', '<>', $thread->post_id)->get();
							$temp_posts = $temp_posts->sortBy('weight')->reverse();
							$count = $temp_posts->count();
							
							$pagination = App::make('paginator');
						    $page = $pagination->getCurrentPage($count);
						    $items = $temp_posts->slice(($page - 1) * $posts_per_page, $posts_per_page)->all();
						    $paginated = $pagination->make($items, $count, $posts_per_page);
						    
							return ['list' => $paginated->getItems(), 'links' => (string) $paginated->appends(array('sort' => Input::get('sort')))->links()];
						});
					}
					//else just get the default posts with the default weight
					else
					{
						$paginated = Post::withTrashed()->where('thread_id', '=', $thread_id)->whereNull('parent_id')->where('id', '<>', $thread->post_id)->orderBy('weight', 'DESC')->paginate($posts_per_page);
						$posts['list'] = $paginated->getItems();
						$posts['links'] = $paginated->appends(array('sort' => Input::get('sort')))->links();
					}
					break;
				default:
					//in case of some weird input, throw 404.
					App::abort(404);
					break;
			}
		}
		//if no sorting options found, sort by weight.
		else
		{
			//if user is authenticated, cache the query
			if (Auth::check())
			{
				$cache_key = 'user_'.Auth::user()->id.'_thread_'.$thread->id.'_page_'.Input::get('page', 1);
				$posts = Cache::remember($cache_key, Config::get('app.cache_posts_for'), function() use ($thread, $posts_per_page)
				{	
					//do not touch. might explode.
					$temp_posts = Post::withTrashed()->where('thread_id', '=', $thread->id)->whereNull('parent_id')->where('id', '<>', $thread->post_id)->get();
					$temp_posts = $temp_posts->sortBy('weight')->reverse();
					$count = $temp_posts->count();
					
					$pagination = App::make('paginator');
				    $page = $pagination->getCurrentPage($count);
				    $items = $temp_posts->slice(($page - 1) * $posts_per_page, $posts_per_page)->all();
				    $paginated = $pagination->make($items, $count, $posts_per_page);
				    
					return ['list' => $paginated->getItems(), 'links' => (string) $paginated->links()];
				});
			}
			//else just get the default posts with the default weight
			else
			{
				$paginated = Post::withTrashed()->where('thread_id', '=', $thread_id)->whereNull('parent_id')->where('id', '<>', $thread->post_id)->orderBy('weight', 'DESC')->paginate($posts_per_page);
				$posts['list'] = $paginated->getItems();
				$posts['links'] = $paginated->links();
			}
		}

        Session::put('thread_id', $thread_id);
		return View::make('content.thread', array('posts' => $posts['list'], 'links' => $posts['links'], 'thread' => $thread, 'title' => 'Monero | '.$thread->forum->name.' &raquo; '.$thread->name));
	}
	
	public function create($forum_id) {
		
		$forum = Forum::findOrFail($forum_id);
		
		if($forum->lock != 0 && !Auth::user()->hasRole('Admin'))
			return Redirect::to(URL::previous())->with('messages', array('You do not have permission to do this'));	
			
		return View::make('content.createThread', array('forum' => $forum, 'title' => 'Monero | Creating a thread in '.$forum->name));
	}
	
	public function submitCreate() {
		
		$forum = Forum::findOrFail(Input::get('forum_id'));
		
		//check the lock
		if($forum->lock != 0 && !Auth::user()->hasRole('Admin'))
				return Redirect::to(URL::previous())->with('messages', array('You do not have permission to do this'));	

		
		if(is_string(Input::get('submit')))
		{
			
			$data = array(
				'forum_id'	=>	Input::get('forum_id'),
				'user_id'	=>  Auth::user()->id,
				'name'		=>  Input::get('name')
			);
			$validator = Thread::validate($data);
			
			if (!$validator->fails() && Input::get('body') != '')
			{
				$thread = new Thread();
				
				$thread->name = Input::get('name');
				$thread->user_id = Auth::user()->id;
				$thread->forum_id = Input::get('forum_id');
				$thread->post_id = 0;
				$thread->save();
				
				$data = array(
					'thread_id'	=>	$thread->id,
					'body'		=>	Input::get('body')
				);
				
				$validator = Post::validate($data);
				
				if (!$validator->fails())
				{
					$post = new Post();
					
					$post->user_id		= Auth::user()->id;
					$post->thread_id	= $thread->id;
					$post->body			= Input::get('body');
					
					$post->save();		
				}
				else {
	                Thread::find($thread->id)->forceDelete(); //delete the created thread if something somewhere goes terribly wrong.
	                return View::make('content.createThread', array('title' => 'Monero | Creating a thread in ' . $forum->name, 'forum' => $forum, 'errors' => $validator->messages()->all()));
	            }
				$thread->post_id = $post->id;
				
				$thread->save();

	            //nuke the cached item if a thread is posted. Or create one.
	            $key = 'forum_latest_thread_'.$thread->forum_id;
	            if (Cache::has($key)) {
	                Cache::forget($key);
	            }
	            else {
	                Cache::remember($key, Config::get('app.cache_latest_details_for'), function() use ($forum)
	                {
	                    return DB::table('forums')
	                        ->where('forums.id', '=', $forum->id)
	                        ->join('threads', 'forums.id', '=', 'threads.forum_id')
	                        ->whereNull('threads.deleted_at')
	                        ->orderBy('threads.updated_at', 'DESC')
	                        ->first();
	                });
	            }
				
				return Redirect::to($thread->permalink());
			}
			else 
				return View::make('content.createThread', array('title' => 'Monero | Create a thread '.$forum->name,'forum' => $forum, 'errors' => $validator->messages()->all()));
		}
		else {
			return Redirect::to(URL::previous())->withInput()->with('preview', Markdown::string(Input::get('body')));
		}
	}
	
	public function delete($thread_id) {
	
		$thread = Thread::findOrFail($thread_id);
		
		if (Auth::check() && Auth::user()->id == $thread->user->id)
		{
			
			foreach ($thread->posts as $post)
			{
				$post->delete();
			}
			
			$thread->delete();
			
			return Redirect::to($thread->forum->permalink())->with('messages', array('The thread has been deleted.'));
		}
		else {
			return View::make('errors.permissions', array('title' => 'Monero | Page not found. Error: 404'));
		}
	}

    public function allRead() {
        
        $forums = Forum::all();
        foreach ($forums as $forum)
        {
        	$keyNewThreads = 'user_'.Auth::user()->id.'_forum_'.$forum->id.'_new_threads';
        	$keyUnreadThreads = 'user_'.Auth::user()->id.'_forum_'.$forum->id.'_unread_threads';

        	//nuke cache if there are any items in the cache.
        	
        	if (Cache::has($keyNewThreads))
        		Cache::forget($keyNewThreads);

        	if (Cache::has($keyUnreadThreads))
        		Cache::forget($keyUnreadThreads);

            $threads = $forum->threads;
            foreach ($threads as $thread)
            {
               $thread_id = $thread->id;

	            $view = ThreadView::where('user_id', Auth::user()->id)->where('thread_id', $thread_id)->first();

		        if ($view)
		        {
		            $view->touch(); //update timestamp
		        }
		        else
		        {
		            //create new viewing entry. updated_at = last view, created_at = first view.
		            $view = new ThreadView();
		            $view->user_id = Auth::user()->id;
		            $view->thread_id = $thread_id;
		            $view->save();
		        }
            }
        }
        return Redirect::to(URL::previous())->with('messages', array('All forums have been marked as read!'));
    }

    public function allForumRead($forum_id) {
        
        $forum = Forum::findOrFail($forum_id);
        $threads = $forum->threads;

        foreach ($threads as $thread)
        {
        	$thread_id = $thread->id;

            $view = ThreadView::where('user_id', Auth::user()->id)->where('thread_id', $thread_id)->first();

	        if ($view)
	        {
	            $view->touch(); //update timestamp
	        }
	        else
	        {
	            //create new viewing entry. updated_at = last view, created_at = first view.
	            $view = new ThreadView();
	            $view->user_id = Auth::user()->id;
	            $view->thread_id = $thread_id;
	            $view->save();
	        }
    	}

        return Redirect::to(URL::previous())->with('messages', array('All threads have been marked as read!'));
    }
}
