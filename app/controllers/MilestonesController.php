<?php

class MilestonesController extends \BaseController {

	public function __construct() {
		$user = Auth::user();
		if(!($user && $user->can('admin_panel')))
		{
			App::abort(404);
		}
	}

	public function index($thread_id)
	{
		$thread = Thread::findOrFail($thread_id);
		return View::make('milestones.index', compact('thread'));
	}

	public function create($id)
	{
		$thread = Thread::findOrFail($id);
		return View::make('milestones.create', compact('thread'));
	}

	public function store()
	{
		Milestone::create(Input::all());

		return Redirect::back();
	}

	public function edit($id)
	{
		$milestone = Milestone::findOrFail($id);
		return View::make('milestones.edit', compact('milestone'));
	}

	public function update($id)
	{
		$milestone = Milestone::findOrFail($id);
		$milestone->title = Input::get('title');
		$milestone->description = Input::get('description');
		$milestone->complete = Input::get('complete');
		$milestone->completed_at = Input::get('completed_at');
		$milestone->save();

		Session::put('messages', ['Milestone updated successfullyt']);

		return Redirect::back();
	}

	public function delete($id)
	{
		$milestone = Milestone::findOrFail($id);
		$milestone->delete();

		return Redirect::back();
	}

}