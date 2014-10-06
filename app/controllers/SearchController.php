<?php

class SearchController extends BaseController {
	
	public function search() {
		if (Input::has('query'))
		{
			$query = strtolower(Input::get('query')); //search is CI
			
			//start the database chain
			$search_query = DB::table('threads')
			->join('posts', 'threads.post_id', '=', 'posts.id')
			->join('users', 'threads.user_id', '=', 'users.id')
			->join('forums', 'threads.forum_id', '=', 'forums.id')
			->join('categories', 'forums.category_id', '=', 'categories.id')
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
			);
			
			//strip the query and add
			
			$chain = array();
			
			//scan through ANDs
			$ANDs = explode(' [and]', $query);
			foreach ($ANDs as $and) {
				//search the AND for ORs
				$ORs = explode(' [or]', $and);
				//only loop through if the arrray is bigger than 1 element (actually has an OR inside it).
				if (sizeof($ORs) > 1)
				{
					foreach ($ORs as $or)
					{
						$chain[] = array(
							'value'	   => $or,
							'operator' => 'or'
						);
					}
				}
				else
				{
					$chain[] = array(
							'value'	   => $and,
							'operator' => 'and'
						);
				}
				
			}
			
			//build the actual query chain
			foreach($chain as $key => $link) {
				
				$chips = preg_replace('/(\w+)\:"(\w+)/', '"${1}:${2}', $link['value']);
				$chips = str_getcsv($chips, ' ');
												
				foreach ($chips as $chip_key => $chip)
				{
						if (!isset($chain[$key-1]['operator']) || $chain[$key-1]['operator'] == 'and')
						{
							//check if a rule is being applied to a specific field
							if (str_contains($chip, ':'))
							{
								$chip_data = str_getcsv($chip, ' ');
								
								$chip_data = explode(':', $chip);
								$field = $chip_data[0];
								$field_data = $chip_data[1];
								
								switch ($field) {
								    case 'title':
								        $search_query = $search_query->where('threads.name', 'LIKE', '%'.$field_data.'%');
								        break;
								    case 'from':
								        $search_query = $search_query->where('users.username', 'LIKE', $field_data);
								        break;
								    case 'forum':
								        $search_query = $search_query->where('forums.name', 'LIKE', '%'.$field_data.'%');
								        break;
								    case 'category':
								        $search_query = $search_query->where('categories.name', 'LIKE', '%'.$field_data.'%');
								        break;
								    //if nothing matches, search for whole chip.
								    default:
								    	$search_query = $search_query->where('posts.body', 'LIKE', '%'.$chip.'%');
								    	break;
								}
							}
							else
							{
								$search_query = $search_query->where('posts.body', 'LIKE', '%'.$chip.'%');
							}
						}
						else if ($chain[$key-1]['operator'] == 'or')
						{
							//check if a rule is being applied to a specific field
							if (str_contains($chip, ':'))
							{
								$chip_data = str_getcsv($chip, ' ');
								
								$chip_data = explode(':', $chip);
								$field = $chip_data[0];
								$field_data = $chip_data[1];
								
								switch ($field) {
								    case 'title':
								        $search_query = $search_query->orWhere('threads.name', 'LIKE', '%'.$field_data.'%');
								        break;
								    case 'from':
								        $search_query = $search_query->orWhere('users.username', 'LIKE', $field_data);
								        break;
								    case 'forum':
								        $search_query = $search_query->orWhere('forums.name', 'LIKE', '%'.$field_data.'%');
								        break;
								    case 'category':
								        $search_query = $search_query->orWhere('categories.name', 'LIKE', '%'.$field_data.'%');
								        break;
								    //if nothing matches, search for whole chip.
								    default:
								    	$search_query = $search_query->where('posts.body', 'LIKE', '%'.$chip.'%');
								    	break;
								}
							}
							else
							{
								$search_query = $search_query->orWhere('posts.body', 'LIKE', '%'.$chip.'%');
							}
						}
				}
			}
			
			$results = $search_query->paginate(20);
			
			$return_data = array(
				'results' => $results,
				'query'	  => $search_query->toSql()
			);
			
			return View::make('search.debug', array('debug' => $return_data));
			
			
			return View::make('search.results', array('results' => $results));
		}
		else
		{
			return View::make('errors.search_empty');
		}
	}
	
	
}