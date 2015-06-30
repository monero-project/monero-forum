<?php

class AdminController extends \BaseController {
	
	public function index() {
		return View::make('admin.index');
	}
	
	public function getCreate($content_type) {
		if ($content_type == 'category')
		{
			return View::make('admin.content.create.category');
		}
		else if ($content_type == 'forum')
		{
			return View::make('admin.content.create.forum');
		}
		else if ($content_type == 'role')
		{
			return View::make('admin.content.create.role');
		}
		else {
			return App::abort(403);
		}
	}
	
	public function postCreate() {
		if (Input::has('type') && Input::get('type') == 'category')
		{
			$category = new Category();
			$category->name = Input::get('name');
			$category->position = Input::get('position');
			$category->save();
			
			return Redirect::to('/admin')->with('messages', array('Category created successfully.'));
		}
		else if (Input::has('type') && Input::get('type') == 'forum')
		{
			$forum = new Forum();
			$forum->name = Input::get('name');
			$forum->position = Input::get('position');
			$forum->category_id = Input::get('category_id');
			$forum->description = Input::get('description');
			$forum->lock = Input::get('lock');
			$forum->save();
			
			return Redirect::to('/admin')->with('messages', array('Forum created successfully.'));
		}
		else if (Input::has('type') && Input::get('type') == 'role')
		{
			$role = new Role();
			$role->name = Input::get('name');
			$role->save();
			
			return Redirect::to('/admin')->with('messages', array('Role created successfully.'));
		}
		else
		{
			return View::make('errors.permission');
		}
	}
	
	public function manage($content_type) {
		switch ($content_type) {
			case 'category':
				return View::make('admin.content.manage.categories');
        break;
			case 'forum':
				return View::make('admin.content.manage.forums');
        break;
			case 'user':
				return View::make('admin.content.manage.users');
		break;
			case 'roles':
				return View::make('admin.users.roles');
		break;
			case 'funds':
				$items = Funding::orderBy('created_at', 'DESC')->paginate(20);
				return View::make('admin.funds', compact('items'));
        break;
			case 'milestones':
				$items = Funding::orderBy('created_at', 'DESC')->paginate(20);
				return View::make('admin.milestones', compact('items'));
		break;
			default:
				return App::abort(403);
		}
	}
	
	public function getEdit($content_type, $content_id) {
		if ($content_type == 'category')
		{
			$category = Category::findOrFail($content_id);
			
			$visible_to = array();
			
			$visibility = Visibility::where('content_type', $content_type)->where('content_id', $content_id)->get();
			
			foreach ($visibility as $to)
			{
				$role = Role::find($to->role_id);
				if ($role)
				{
					$visible_to[] = $role->name;
				}
			}
			
			return View::make('admin.content.edit.category', array('category' => $category, 'visible_to' => $visible_to));
		}
		else if ($content_type == 'forum')
		{
			$forum = Forum::findOrFail($content_id);
			
			$visible_to = array();
			
			$visibility = Visibility::where('content_type', $content_type)->where('content_id', $content_id)->get();
			
			foreach ($visibility as $to)
			{
				$role = Role::find($to->role_id);
				if ($role)
				{
					$visible_to[] = $role->name;
				}
			}
			
			return View::make('admin.content.edit.forum', array('forum' => $forum, 'visible_to' => $visible_to));
		}
		else if ($content_type == 'user')
		{
			$user = User::findOrFail($content_id);
			return View::make('admin.content.edit.user', array('user' => $user));
		}
		else if ($content_type == 'role')
		{
			$role = Role::findOrFail($content_id);
			return View::make('admin.content.edit.role', array('role' => $role));
		}
		else {
			return App::abort(403);
		}
	} 
	
	public function postEdit() {
			
		if (Input::has('type') && Input::get('type') == 'category')
		{
			$category = Category::findOrFail(Input::get('id'));
			$category->name = Input::get('name');
			$category->position = Input::get('position');
			$category->save();
			
			//clear all the visibility rules
			foreach(Visibility::where('content_type', Input::get('type'))->where('content_id', Input::get('id'))->get() as $item_to_delete)
			{
				$item_to_delete->delete();
			}
			
			//insert new visibility rules.
			foreach(Input::get('visibility') as $role_id)
			{
				$visible = new Visibility();
				$visible->role_id = $role_id;
				$visible->content_id = Input::get('id');
				$visible->content_type = Input::get('type');
				$visible->save();
			}
			
			return Redirect::to(URL::previous())->with('messages', array('Category saved successfully.'));
		}
		else if (Input::has('type') && Input::get('type') == 'forum')
		{
			$forum = Forum::findOrFail(Input::get('id'));
			$forum->name = Input::get('name');
			$forum->position = Input::get('position');
			$forum->category_id = Input::get('category_id');
			$forum->description = Input::get('description');
			$forum->lock = Input::get('lock');
			$forum->save();
			
			//clear all the visibility rules
			foreach(Visibility::where('content_type', Input::get('type'))->where('content_id', Input::get('id'))->get() as $item_to_delete)
			{
				$item_to_delete->delete();
			}
			
			//insert new visibility rules.
			foreach(Input::get('visibility') as $role_id)
			{
				$visible = new Visibility();
				$visible->role_id = $role_id;
				$visible->content_id = Input::get('id');
				$visible->content_type = Input::get('type');
				$visible->save();
			}
			
			return Redirect::to(URL::previous())->with('messages', array('Forum saved successfully.'));
		}
		else if (Input::has('type') && Input::get('type') == 'user')
		{	
			$user = User::findOrFail(Input::get('id'));
			$user->username = Input::get('username');
			$user->email = Input::get('email');
						
			if (Input::get('confirmed') == 'on')
				$user->confirmed = 1;
			else
				$user->confirmed = 0;
			
			if (Input::has('key_id'))
				$user->key_id = Input::get('key_id');
			
			if (Input::has('role'))
			{
				DB::table('assigned_roles')->where('user_id', $user->id)->delete();
				$role = Role::where('id', Input::get('role'))->get()->first();
				$user->roles()->attach($role);
			}
				
			if (Input::get('password') != '')
			{
				if (Input::get('password') == Input::get('password_confirmation'))
				{
					$user->password = Hash::make(Input::get('password'));
				}
				else
				{
					return Redirect::to(URL::previous())->with('messages', array('Password mismatch.'));
				}
			}
			
			$user->save();
			
			return Redirect::to(URL::previous())->with('messages', array('User saved successfully.'));
			
		}
		else if (Input::has('type') && Input::get('type') == 'role')
		{
			$role = Role::findOrFail(Input::get('id'));
			$role->name = Input::get('name');
			$role->save();
			
			return Redirect::to(URL::previous())->with('messages', array('Role saved successfully.'));
			
		}
		else {
			return App::abort(403);
		}
	}
	
	public function delete($content_type, $content_id) {
		if ($content_type == 'category')
		{
			$category = Category::findOrFail($content_id);
			
			foreach($category->forums as $forum)
			{
				foreach($forum->threads as $thread)
				{
					foreach($thread->posts as $post)
					{
						$post->delete();
					}
					$thread->delete();
				}
				$forum->delete();
			}
			$category->delete();
			
			return Redirect::to('/admin')->with('messages', array('Category deleted.'));
		}
		else if ($content_type == 'forum')
		{
			$forum = Forum::findOrFail($content_id);
			
			foreach($forum->threads as $thread)
			{
				foreach($thread->posts as $post)
				{
					$post->delete();
				}
				
				$thread->delete();
			}
			
			$forum->delete();
			
			
			return Redirect::to('/admin')->with('messages', array('Forum deleted.'));
		}
		else if ($content_type == 'user')
		{
			$user = User::findOrFail($content_id);
			
			foreach($user->threads as $thread)
			{
				foreach($thread->posts as $post)
				{
					$post->delete();
				}
				$thread->delete();
			}
			
			foreach($user->posts as $post)
			{
				$post->delete();
			}
			
			$user->delete();
			
			return Redirect::to('/admin')->with('messages', array('User deleted.'));
		}
		else if ($content_type == 'post')
		{
			$post = Post::findOrFail($content_id);
			if($post->thread->head()->id == $post->id)
			{
				foreach($post->thread->posts as $thread_post)
				{
					$thread_post->delete();
				}
				$post->thread->delete();
			}
			
			foreach($post->flags as $flag)
			{
				$flag->delete();
			}
			
			$post->delete();
			
			return Redirect::to('/admin')->with('messages', array('Post deleted.'));
		}
		else if ($content_type == 'role')
		{
			$roles = DB::table('assigned_roles')->where('role_id', $content_id)->get();
			
			foreach ($roles as $role)
			{
				$role->delete();
			}
			
			$role = Role::find($content_id)->delete();
			
			return Redirect::to('/admin')->with('messages', array('Role deleted.'));
		}
		else {
			return App::abort(403);
		}
	}
	
	public function changeStatus($flag_id, $status) {
		
		$flag = Flag::findOrFail($flag_id);
		$flag->status = $status;
		$flag->save();
		
		return Redirect::to(URL::previous())->with('messages', array('Status updated.'));
	}
	
	public function flush() {
		Cache::flush();
		
		return Redirect::to(URL::previous())->with('messages', array('Cache flushed.'));
	}
	
	public function accessLog($username) {
		$user = User::where('username', $username)->first();
		$access_log = $user->access()->paginate('30');
						
		return View::make('admin.users.access', array('user' => $user, 'access_log' => $access_log));
	}
}