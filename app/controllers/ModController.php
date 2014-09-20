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
	
}