<?php

class HomeController extends \BaseController {

	public function index()
	{
		$categories = Category::orderBy('position', 'ASC')->get();
		
		return View::make('content.index', array('categories' => $categories));
	}

}
