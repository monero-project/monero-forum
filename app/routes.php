<?php
Route::get('/', 'HomeController@index');

/* User Controllers */
Route::get('/user/profile', array('before'  => 'auth',  'uses'  => 'UsersController@self'));
Route::get('/user/settings', 'UserController@settings');
Route::get('/user/{user_id}', 'UsersController@profile');
Route::get('/user/{user_id}/posts', 'UsersController@posts');
Route::get('/user/{user_id}/threads', 'UsersController@threads');
Route::get('/user/{user_id}/{rating_way}/{rating_type}', 'UsersController@ratings');

Route::post('/login',   array('before'  => 'guest', 'uses'  => 'UsersController@login'));
Route::post('/register',  array('before' => 'guest',  'uses'  => 'UsersController@register'));
Route::get('/login',   array('before'  => 'guest', 'uses'  => 'UsersController@showLogin'));
Route::get('/register',  array('before'  => 'guest', 'uses'  => 'UsersController@showRegister'));
Route::get('/logout',   array('before'  => 'auth',  'uses'  => 'UsersController@logout'));

/*	Posts	*/
Route::post('/posts/submit', array('before'  => 'auth',  'uses'  => 'PostsController@submit'));
Route::post('/posts/update', array('before'  => 'auth',  'uses'  => 'PostsController@update'));
Route::get('/posts/delete/{post_id}', array('before'  => 'auth',  'uses'  => 'PostsController@delete'));
Route::get('/posts/get/{post_id}', array('before'  => 'auth',  'uses'  => 'PostsController@get'));

/*	Ratings		*/
Route::post('/ratings/rate', array('before'  => 'auth',  'uses'  => 'RatingsController@rate'));

/*	API Layer	*/

Route::get('/keychain/exists/{username}', 'KeychainController@exists');
Route::get('/keychain/message/{key_id}', 'KeychainController@message');
Route::get('/keychain/sync/push/users', 'KeychainController@users');
Route::get('/keychain/sync/pull/ratings',  array('before'   => 'auth',  'uses'   => 'KeychainController@pullRatings'));
Route::post('/keychain/sync/push/ratings',  array('before'   => 'auth',  'uses'   => 'KeychainController@pushRatings'));
Route::get('/keychain/sync/push/ratings', 'KeychainController@listRatings');
Route::get('/keychain/ratings',  array('before'   => 'auth',  'uses'   => 'KeychainController@myRatings'));
Route::get('/keychain/ratings/download', array('before' => 'auth', 'uses' => 'KeychainController@downloadRatings'));

/* Forum Structure */
Route::get('/{forum_slug}/{forum_id}', 'ForumsController@index');
Route::get('/{forum_slug}/{forum_id}/{thread_slug}/{thread_id}', 'ThreadsController@index');
Route::get('/{forum_slug}/{forum_id}/{thread_slug}/{thread_id}/{post_slug}/{post_id}', 'PostsController@index');


//Testing purposes
Route::get('/do', 'KeychainController@action');
