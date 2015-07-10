<?php

class PayoutsController extends \BaseController {


	public function getCreate($id) {
		return View::make('payout.create', compact('id'));
	}

	public function postStore($id) {

		$data               = Input::all();
		$data['funding_id'] = $id;

		if(Auth::check() && Auth::user()->can('admin_panel'))
		{
			Payout::create($data);
			Session::put('messages', ['Payout created successfully']);
		}
		else
		{
			Session::put('errors', ['Insufficient permissions']);
		}

		return Redirect::back();
	}


	public function getDestroy($id) {
		if(Auth::check() && Auth::user()->can('admin_panel')) {
			$payout = Payout::findOrFail($id);
			$payout->delete();
			Session::put('messages', ['Payout deleted successfully']);
		}
		else
		{
			Session::put('errors', ['Insufficient permissions']);
		}
		return Redirect::back();
	}

}