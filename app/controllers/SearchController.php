<?php

class SearchController extends BaseController {
	
	public function search() {
		if (Input::has('query'))
		{
			$query = strtolower(Input::get('query')); //search is CI

			$search_query = DB::table('posts')
			->leftJoin('threads', 'posts.thread_id', '=', 'threads.id')
			->leftJoin('users', 'threads.user_id', '=', 'users.id')
			->leftJoin('forums', 'threads.forum_id', '=', 'forums.id')
			->leftJoin('categories', 'forums.category_id', '=', 'categories.id')
			->select(
				'users.id as user_id',
				'posts.id as post_id',
				'forums.id as forum_id',
				'users.username as username',
				'posts.created_at as created_at',
				'categories.id as category_id',
				'posts.body as body',
				'threads.name as name',
				'threads.id as id',
				'users.profile_picture as profile_picture'
			)
			->whereNull('posts.deleted_at');

			preg_match_all('/(\S*(:(".*?")))|(\S*(:\S*))|(".*?")|\w+/', $query, $chips);

			$chips = $chips[0];

			echo "<pre>";
			exit(dd($chips));

			foreach ($chips as $key => $chip)
			{
				//examine the chip
				if(str_contains($chip, ':'))
				{
					$explosions = explode(':', $chip, 2);
					$column = $explosions[0];
					$text = str_replace('"', "", $explosions[1]);

					$is_or = $key != 0 && $chip[$key-1] == 'or'; //check if is previous word is or

					//have to check every possible search key,
					//because cannot let people enter random stuff into the query.
					switch($column) {
						case 'title':
							if($is_or)
								$search_query = $search_query->orWhere('threads.name', 'LIKE', '%'.$text.'%');
							else
								$search_query = $search_query->where('threads.name', 'LIKE', '%'.$text.'%');
							break;
						case 'body':
							if($is_or)
								$search_query = $search_query->orWhere('posts.body', 'LIKE', '%'.$text.'%');
							else
								$search_query = $search_query->where('posts.body', 'LIKE', '%'.$text.'%');
							break;
						case 'author':
							if($is_or)
								$search_query = $search_query->orWhere('users.username', 'LIKE', '%'.$text.'%');
							else
								$search_query = $search_query->where('users.username', 'LIKE', '%'.$text.'%');
							break;
						default:
							//if there is no column given, clean the chip and match with title or body
							//TODO: possibly implement HAVING for better results.
							$term = str_replace('"', "", $chip);
							if($is_or)
								$search_query = $search_query->orWhere('posts.body', 'LIKE', '%'.$term.'%')->orWhere('threads.name', 'LIKE', '%'.$term.'%');
							else
								$search_query = $search_query->where('posts.body', 'LIKE', '%'.$term.'%')->orWhere('threads.name', 'LIKE', '%'.$term.'%');
							break;
					}
				}
				else {
					//run as raw query, without building
					$search_query = $search_query->where('threads.name', 'LIKE', '%'.$query.'%')->orWhere('posts.body', 'LIKE', '%'.$query.'%');
				}

			}
			$results = $search_query->paginate(20);
//			foreach ($search_results as $result)
//			{
//				echo $result->username."<br>";
//				echo $result->name."<br>";
//				echo $result->body."<br>";
//			}

			return View::make('search.results', array('results' => $results));

		}
		else
		{
			return View::make('errors.search_empty');
		}
	}
	
	
}