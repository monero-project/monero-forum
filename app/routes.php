<?php

/* Home Page */
Route::get('/', array(
	'as'    => 'index',
	'uses'  => 'HomeController@index'
));

Route::get('/akismet/spam/{id}', ['as' => 'akismet.spam', 'uses' => 'AkismetController@spam']);
Route::get('/akismet/ham/{id}', ['as' => 'akismet.ham', 'uses' => 'AkismetController@ham']);
Route::get('/akismet/approve/{id}', ['as' => 'akismet.approve', 'uses' => 'AkismetController@approve']);
Route::get('/akismet/delete/{id}', ['as' => 'akismet.delete', 'uses' => 'AkismetController@delete']);
Route::get('/akismet/nuke/{id}', ['as' => 'akismet.nuke', 'uses' => 'AkismetController@nuke']);


/* Email Replies */
//pretty random, non-structural URL.
Route::post('/email-conversation-reply', 'MessagesController@emailReply');

/* Image Proxy */
Route::get('/get/image/', 'PostsController@getProxyImage');

/* Search */
Route::post('/search', 'SearchController@search');

/* Contribute */
Route::get('/contribute/{id}', array('as' => 'contribute', 'uses' => 'ThreadsController@contribute'));

/* Milestone Management */

Route::post('/milestones/store', array('as' => 'milestones.store', 'uses' => 'MilestonesController@store'));
Route::get('/milestones/create/{id}', array('as' => 'milestones.create', 'uses' => 'MilestonesController@create'));
Route::get('/milestones/edit/{id}', array('as' => 'milestones.edit', 'uses' => 'MilestonesController@edit'));
Route::post('/milestones/update/{id}', array('as' => 'milestones.update', 'uses' => 'MilestonesController@update'));
Route::get('/milestones/delete/{id}', array('as' => 'milestones.delete', 'uses' => 'MilestonesController@delete'));

Route::get('/milestones/{thread_id}', array('as' => 'milestones.index', 'uses' => 'MilestonesController@index'));


/* Admin Panel */
Route::get('/admin', 'AdminController@index');

//Manage Content
Route::get('/admin/manage/{content_type}', 'AdminController@manage');
Route::get('/admin/create/{content_type}', 'AdminController@getCreate');
Route::get('/admin/edit/{content_type}/{content_id}', 'AdminController@getEdit');
Route::get('/admin/delete/{content_type}/{content_id}', ['as' => 'admin.delete', 'uses' => 'AdminController@delete']);

Route::post('/admin/create', 'AdminController@postCreate');
Route::post('/admin/edit', 'AdminController@postEdit');

Route::get('/admin/flag/status/{flag_id}/{status}', 'AdminController@changeStatus');
Route::get('/admin/access/{username}', 'AdminController@accessLog');

//Flush Cache
Route::get('/admin/cache/flush', 'AdminController@flush');

/* Mod Actions */

//Move Thread
Route::get('/mod/move/thread/{thread_id}', array('before' => 'mod', 'uses' => 'ModController@getMove'));
Route::post('/mod/move/thread/', array('before' => 'mod', 'uses' => 'ModController@postMove'));

//Deletes
Route::get('/mod/delete/{content_type}/{content_id}', array('as' => 'mod.delete', 'before' => 'mod', 'uses' => 'ModController@delete'));

/* User Controller */
Route::get('/user/profile', array('as' => 'user.profile', 'before' => 'auth', 'uses' => 'UsersController@self'));
Route::get('/user/settings', 'UserController@settings');
Route::get('/user/forgot-password', 'UsersController@getForgotPassword');
Route::post('/user/forgot-password', 'UsersController@postForgotPassword');
Route::get('/user/resend-activation', 'UsersController@getResend');
Route::post('/user/resend-activation/', 'UsersController@postResend');
Route::post('/user/settings/view/save', array('before' => 'auth', 'uses' => 'UsersController@viewSave'));
Route::post('/user/settings/parent/save', array('before' => 'auth', 'uses' => 'UsersController@parentSave'));
Route::get('/user/settings/add-key', array('before' => 'auth', 'uses' => 'UsersController@getAddGPG'));
Route::post('/user/settings/notifications/save', array('before' => 'auth', 'as' => 'user.notifications.save', 'uses' => 'UsersController@notificationsSave'));
Route::post('/user/settings/add-gpg', array('before' => 'auth', 'uses' => 'UsersController@postAddGPGKey'));
Route::post('/user/settings/gpg-decrypt', array('before' => 'auth', 'uses' => 'UsersController@postGPGDecrypt'));
Route::get('/user/settings/confirmation/inactive', array('before' => 'auth', 'uses' => 'UsersController@accountInactive'));
Route::get('/user/settings/delete/picture', array('before' => 'auth', 'uses' => 'UsersController@deleteProfile'));
Route::get('/user/activate/{user_id}/{code}', 'UsersController@getActivate');
Route::get('/user/activate/resend/{user_id}', 'UsersController@getResend');
Route::get('/user/recover/{user_id}/{recovery_token}', 'UsersController@getChangePassword');
Route::post('/user/recover/', 'UsersController@postChangePassword');
Route::get('/user/{username}', array(
	'as'    => 'user.show',
	'uses'  => 'UsersController@profile'
));
Route::get('/user/{username}/feed', 'FeedsController@userFeed');
Route::get('/user/{user_id}/posts', 'UsersController@posts');
Route::get('/user/{user_id}/threads', 'UsersController@threads');
Route::get('/user/{user_id}/{rating_way}/{rating_type}', 'UsersController@ratings');

/*User settings*/
Route::get('/user/settings', array('before' => 'auth', 'uses' => 'UsersController@settings'));
Route::post('/user/upload/profile', array('before' => 'auth', 'uses' => 'UsersController@uploadProfile'));
Route::post('/user/settings/save', array('before' => 'auth', 'uses' => 'UsersController@settingsSave'));

//Mark all as read
Route::get('/users/action/allread', array('before' => 'auth', 'uses' => 'ThreadsController@allRead'));
Route::get('/users/action/allread/{forum_id}', array('before' => 'auth', 'uses' => 'ThreadsController@allForumRead'));

Route::post('/login', array('before' => 'guest', 'uses' => 'UsersController@login'));
Route::post('/register', array('before' => 'guest', 'uses' => 'UsersController@register'));
Route::get('/login', array('before' => 'guest', 'uses' => 'UsersController@showLogin'));
Route::get('/register', array('before' => 'guest', 'uses' => 'UsersController@showRegister'));
Route::get('/logout', array('before' => 'auth', 'uses' => 'UsersController@logout'));
Route::post('/gpg-auth', array('before' => 'auth', 'as' => 'gpg.auth' , 'uses' => 'UsersController@gpgAuth'));
Route::get('/gpg-auth', array('before' => 'auth', 'uses' => 'UsersController@getGPGAuth'));

/*	Posts	*/
Route::post('/posts/submit', array('before' => 'auth', 'uses' => 'PostsController@submit'));
Route::post('/posts/update', array('before' => 'auth', 'uses' => 'PostsController@update'));
Route::post('/posts/kramdown', 'PostsController@kramdownParse');

/*	Threads	*/
Route::get('/thread/create/{forum_id}', array('before' => 'auth', 'as' => 'thread.create', 'uses' => 'ThreadsController@create'));
Route::post('/thread/create', array('before' => 'auth', 'uses' => 'ThreadsController@submitCreate'));
Route::get('/thread/delete/{thread_id}', array('before' => 'auth', 'uses' => 'ThreadsController@delete'));

//AJAX calls
Route::get('/posts/delete/{post_id}', array('as' => 'post.delete', 'before' => 'auth', 'uses' => 'PostsController@delete'));
Route::get('/posts/get/{post_id}', array('before' => 'auth', 'uses' => 'PostsController@get'));

//Standalone Pages
Route::get('/posts/update/{post_id}', array('before' => 'auth', 'uses' => 'PostsController@getUpdatePage'));
Route::get('/posts/delete/page/{post_id}', array('before' => 'auth', 'uses' => 'PostsController@getDeletePage'));
Route::get('/posts/reply/{post_id}', array('before' => 'auth', 'uses' => 'PostsController@getReplyPage'));

//Reports
Route::get('/posts/report/{post_id}/{page_number}', array('as' => 'post.report', 'before' => 'auth', 'uses' => 'PostsController@getReportPage'));
Route::post('/posts/report/', array('before' => 'auth', 'uses' => 'PostsController@postReport'));

//Sticky

Route::get('/posts/sticky/{id}', ['as' => 'post.stick', 'before' => 'auth', 'uses' => 'PostsController@stick']);

/*	Votes	*/
Route::post('/votes/vote', array('before' => 'auth', 'uses' => 'VotesController@postVote'));
Route::get('/votes/vote/', array('before' => 'auth', 'uses' => 'VotesController@getVote'));

/*	Ratings	*/
Route::post('/ratings/rate', array('before' => 'auth', 'uses' => 'RatingsController@rate'));

/*	Keychain Layer	*/
Route::get('/keychain/exists/{username}', 'KeychainController@exists');
Route::get('/keychain/message/{key_id}', 'KeychainController@message');
Route::get('/keychain/sync/push/users', 'KeychainController@users');
Route::get('/keychain/sync/pull/ratings', array('before' => 'auth', 'uses' => 'KeychainController@pullRatings'));
Route::post('/keychain/sync/push/ratings', array('before' => 'auth', 'uses' => 'KeychainController@pushRatings'));
Route::get('/keychain/sync/push/ratings', 'KeychainController@listRatings');
Route::get('/keychain/ratings', array('before' => 'auth', 'uses' => 'KeychainController@myRatings'));
Route::get('/keychain/ratings/download', array('before' => 'auth', 'uses' => 'KeychainController@downloadRatings'));

Route::get('/keychain/posts/get/{thread_id}/{posts_num}', 'PostsController@listPosts');

Route::get('/keychain/trust/{level}/{id}', 'KeychainController@trust');

/* Private Messaging */

Route::controller('messages', 'MessagesController', [
	'getIndex'          => 'messages.index',
	'getCreate'         => 'messages.create',
	'postSend'          => 'messages.send',
	'postReply'         => 'messages.reply',
	'getConversation'   => 'messages.conversation'
]);

Route::controller('notifications', 'NotificationsController', [
	'getIndex'      => 'notifications.index',
	'getCount'      => 'notifications.count',
	'getGenerate'   => 'notifications.generate',
	'getRss'        => 'notifications.rss'
]);

Route::controller('subscriptions', 'SubscriptionsController', [
	'getIndex'          => 'subscriptions.index',
	'getSubscribe'      => 'subscriptions.subscribe',
	'getUnsubscribe'    => 'subscriptions.unsubscribe',
	'postSave'          => 'subscriptions.save'
]);

/* Payouts */
Route::controller('payouts', 'PayoutsController', [
	'getCreate'     => 'payout.create',
	'postStore'     => 'payout.store',
	'getDestroy'    => 'payout.delete'
]);

/* Forum Structure */
Route::get('/t/{id}', array('as' => 'thread.short', 'uses' => 'ThreadsController@indexShort')); //shorthand for reaching threads.
Route::get('/{forum_id}/{forum_slug}', array('as' => 'forum.index', 'uses' => 'ForumsController@index'));
Route::get('/{forum_id}/{forum_slug}/feed', 'FeedsController@forumFeed');
Route::get('/{forum_id}/{forum_slug}/{thread_id}/{thread_slug}', array('as' => 'threadView', 'uses' => 'ThreadsController@index'));
Route::get('/{forum_id}/{forum_slug}/{thread_id}/{thread_slug}/feed', 'FeedsController@threadFeed');
Route::get('/{forum_id}/{forum_slug}/{thread_id}/{thread_slug}/{post_id}/{post_slug}', 'PostsController@index');
