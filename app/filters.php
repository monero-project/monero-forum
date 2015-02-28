<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
	//
});


App::after(function($request, $response)
{
	if (Auth::check() && Route::currentRouteName() == 'threadView' && !Input::has('page')) {
        $thread_id = Session::pull('thread_id');
        //register the thread as viewed at X time.

        //check if the thread has been viewed
        $view = ThreadView::where('user_id', Auth::user()->id)->where('thread_id', $thread_id)->first();

        if ($view)
        {
            $view->touch(); //update timestamp
        }
        else
        {
            //create new viewing entry. updated_at = last view, created_at = first view.
            $view = new ThreadView();
            $view->user_id = Auth::user()->id;
            $view->thread_id = $thread_id;
            $view->save();
        }
    }
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{
	if (Auth::guest())
	{
		if (Request::ajax())
		{
			return Response::make('Unauthorized', 401);
		}
		else
		{
			return Redirect::guest('login');
		}
	}
});


Route::filter('auth.basic', function()
{
	return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('/');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() != Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});

/*
|
|	Roles and Permissions filters
|
*/
Entrust::routeNeedsPermission('admin*', 'admin_panel', View::make('errors.permissions'));

Route::filter('moderator', function()
{
    if (! Entrust::hasRole('Moderator') ) // Checks the current user
    {
        App::abort(404);
    }
});


/*
 *      Global Filters
 *
 */

//  Check if user is authenticated via gpg
Route::filter('gpg-auth', function() {
	if (Auth::user()) {
		$user = Auth::user();
		$path = Route::getCurrentRoute()->getPath();

		$is_logout = !str_contains($path, 'logout');
		$is_message = !str_contains($path, 'keychain/message');
		$is_auth = $path != 'gpg-auth';

		if (!$user->gpg_auth && $is_auth && $is_message && $is_logout && $user->in_wot && $user->key_id) {
			$otcp = "forum.monero:" . str_random(40) . "\n";

			$key_id = $user->key_id;

			putenv("GNUPGHOME=/tmp");
			$gpg = new gnupg();
			$gpg->addencryptkey($user->fingerprint);
			$message = $gpg->encrypt($otcp);


			Key::create([
				'key_id'    => $key_id,
				'password'  => Hash::make($otcp),
				'message'   => $message
			]);

			return Redirect::route('gpg.auth');
		}
	}
});

// Check if session is not expired

Route::filter('expired', function() {
	if(Auth::check())
	{
		$user = Auth::user();
		if ($user->remember_for && $user->remember_for != 0)
		{
			$last_login = $user->last_login;
			$last_login = new Carbon($last_login);
			$last_login->addMinutes($user->remember_for);

			if ($last_login->lt(Carbon::now()))
			{
				$user->remember_for = NULL;
				$user->save();

				Auth::logout();
				Session::put('messages', array('Your session has expired. We have logged you out.'));
			}
		}
	}
});