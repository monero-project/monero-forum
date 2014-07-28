<?php

class HomeController extends \BaseController {

	/**
	 * Display the homepage
	 *
	 * @return Response
	 */
	public function index()
	{
		$categories = Category::all();
		
		return View::make('content.index', array('categories' => $categories));
	}

}
