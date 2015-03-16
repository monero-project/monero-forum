<?php
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Carbon\Carbon;

/*
|--------------------------------------------------------------------------
| Register The Laravel Class Loader
|--------------------------------------------------------------------------
|
| In addition to using Composer, you may use the Laravel class loader to
| load your controllers and models. This is useful for keeping all of
| your classes in the "global" namespace without Composer updating.
|
*/

ClassLoader::addDirectories(array(

	app_path().'/commands',
	app_path().'/controllers',
	app_path().'/models',
	app_path().'/database/seeds'

));

/*
|--------------------------------------------------------------------------
| Application Error Logger
|--------------------------------------------------------------------------
|
| Here we will configure the error logger setup for the application which
| is built on top of the wonderful Monolog library. By default we will
| build a basic log file setup which creates a single file for logs.
|
*/

Log::useFiles(storage_path().'/logs/laravel.log');

/*
|--------------------------------------------------------------------------
| Application Error Handler
|--------------------------------------------------------------------------
|
| Here you may handle any errors that occur in your application, including
| logging them or displaying custom views for specific errors. You may
| even register several error handlers to handle different types of
| exceptions. If nothing is returned, the default error view is
| shown, which includes a detailed stack trace during debug.
|
*/
/*App::missing(function($e)
{
    return View::make('errors.404', array('title' => 'Monero | Page not found. Error: 404'));
});

App::error(function(Illuminate\Database\Eloquent\ModelNotFoundException $e) {
	Log::error('404: '.$e);
	return View::make('errors.404', array('title' => 'Monero | Page not found. Error: 404'));
});

App::error(function(ReflectionException $e) {
	Log::error($e);
	//Log::error('902: '.$e);
	//return View::make('errors.902', array('title' => 'Monero | Internal Error. Error: 902'));
});*/
App::error(function(Exception $e, $code)
{
	Log::error($e);
});

/*
|--------------------------------------------------------------------------
| Maintenance Mode Handler
|--------------------------------------------------------------------------
|
| The "down" Artisan command gives you the ability to put an application
| into maintenance mode. Here, you will define what is displayed back
| to the user if maintenance mode is in effect for the application.
|
*/

App::down(function()
{
	return Response::make("Be right back!", 503);
});

/*
|--------------------------------------------------------------------------
| Require The Filters File
|--------------------------------------------------------------------------
|
| Next we will load the filters file for the application. This gives us
| a nice separate location to store our route and application filter
| definitions instead of putting them all in the main routes file.
|
*/

require app_path().'/filters.php';

/*
|
|	Event Listeners
|
*/

Event::listen('auth.login', function($user)
{		

		//logging user logins. IPs and User Agents.
		
    	$log = new Access();
		
		$log->user_id 		= $user->id;
		
		if (Request::header('X-Forwarded-For') != NULL)
			$log->ip = Request::header('X-Forwarded-For');
		else
			$log->ip = Request::getClientIp();
		
		$log->user_agent	= Request::server('HTTP_USER_AGENT');
		
		$user->last_login 	= new DateTime();
		 
		$user->save(); 
		$log->save();
});	

Event::listen('auth.logout', function($user)
{

	$user->gpg_auth = 0;
	$user->save();

});

/* Post Helpers File. Used for recursive functions and whatever else. */
require app_path().'/post_helpers.php';
/* GPG helper file */
require app_path().'/libraries/lib.gpg.php';
/* Notification Handler */
require app_path().'/handlers/Notifications.php';