<?php

class ModController extends \BaseController {
	
	public function postMove() {
		$thread = Thread::find(Input::get('thread_id'));
		$thread->moved = $thread->forum_id;
		$thread->forum_id = Input::get('move_to');
		
		$thread->save();
		
		return Redirect::to(URL::previous())->with('messages', array('Thread moved successfully.'));
	}
	
	public function getMove($thread_id) {
		$thread = Thread::findOrFail($thread_id);
		return View::make('mod.move', array('thread' => $thread));
	}
	
	public function delete($content_type, $content_id) {
		if ($content_type == 'thread')
		{
			$thread = Thread::findOrFail($content_id);
			
			foreach($thread->posts as $post)
			{
				$post->delete();
			}
			
			$thread->delete();

			Cache::flush();
			
			return Redirect::to('/')->with('messages', array('Forum deleted.'));
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

			Cache::flush();

			return Redirect::to('/')->with('messages', array('Post deleted.'));
		}
		else {
			return App::abort(403);
		}
	}

	
}