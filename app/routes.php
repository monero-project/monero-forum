<?php

Route::get('/test', function() {
	$gpg = gnupg_init();

	putenv("GNUPGHOME=/tmp");
	$pubkey = "-----BEGIN PGP PUBLIC KEY BLOCK-----
Version: SKS 1.1.5
Comment: Hostname: pgp.mit.edu

mQENBFFi2TMBCACgt1CvPYw/3A5ygzQq4QEqBnh1Td7h3Hfd/SBdZDuZHypO8raHM/60m3kq
l50olpzlArFSIhgOIIoGyjqkfNqnqw2QHTgh1eB2zKYNsIIyKqyipB4BOEondI/0r5tJlLBF
cVK5JTd3KzdbgXDNmSo2ahB0mW0hxNyegb7L5RQIzkjZnuV5uUUdWB7FZ4WjLDfRB1GaLq+4
pLpCJghHBU/qF7hJn7RDwoybv6thTnsDp7M6bmu5DYSp2rfpLfPlm7dcvBvo9PuOURad3QsQ
EYGGqK/Bdqg+CymyiH1/yapKRCeWQhf8Bl5VYzuOZ085PDXRfZlqmohCHvD1hzMF8rJ3ABEB
AAG0IFJpY2NhcmRvIFNwYWduaSA8cmljQHNwYWduaS5uZXQ+iQEcBBABCAAGBQJTrsKSAAoJ
EJ8xgCx5ZC8ldgcH/1007gKaplGwFG00a6gAcqJewrKK6j5bHMkS5c5dCJO9gq130AbBEre6
hWH9I05XadnRcpKw4OhtPqXbAOA4ZkJvv9bGSySHiqA45GA9kke8kH91uomVQIXVr9ze8tPY
TxMqu8CCDJukGTmIcGasjz/hLflem71nmafSlLDirf/njbKjZNKsKJzfDgWnoBy/NShWghQ2
j6Eouj2XCgvOebmcoRVWaTCJsZaa+xMdcx5n4Z1f4dTwdZKc+1lGZWczmrizosQ477A/8eJj
mlv9+9mbc4N10EHXo3ojZierXueqoqXiKGfTGnVkc3VcG4gulMNFD2QtVB06O44hAOKNc5mJ
ATcEEwEKACEFAlFi2TMCGy8FCwkIBwMFFQoJCAsFFgIDAQACHgECF4AACgkQdFXF48DNzrm4
UQf/WyG7p4qXJjOR1yz/DE5B827IaEXEzmChd4If1NRM7e+iHGAiMrf9y20rxBF/xe52eoEO
Ey848oCLBEppm8CEH+56RqHpAkJPl2DZHx6KftMBqfIg/cxDkXyBXHWKN2taJc2zlUegT40n
YGCE6+cgGsTbWx1bAwyyAqdOgzvZxswmJmCZL2Os7rQ0SZVgu5XqBzJbbHj/IrFZeviy9u0E
nVqy9JqpIlNAAP5BEUYf9/C5BxRGrhlf3fseiaxR6NPLW58/qGORuXAqApX8nB6TdUEu1nhq
fECSGNL4TLUiGD7WVYLIiGX1BSK4CEj/9vVactZfBhuVV/I1/NF/JZeXUYkBgQQTAQgAawUC
U8R47gWDCWYBgF4UgAAAAAAVAEBibG9ja2hhc2hAYml0Y29pbi5vcmcwMDAwMDAwMDAwMDAw
MDAwMjM4NjY1NGI0ZGYyZTkwNjQzNzllM2Y4ZTRjYmZkYThkZDczODZlMjQ3MDg5NzZlAAoJ
EH+rEUJn5PoEfBMIAI+D9uX3FHJ6stTBYTgSObR+5GcS3D4LcjV4z0i0hxeQqWp1HU8/rPHB
TfBMhDB6HfLTBQaUjIBKpOR3YXfpqWUTWD5zgKzTCUCsv+hsMUUKhRf37HEvmgNpVUfQVPpO
/sDXbbSP7VAi2NSSxE/Oni/4/vzpSJl0eR2bAxSJbyQfz6eIlLIDbqwUsY1ecIjN7fOnM8d7
YN/OQ17CcY0mKZgqNOGMPmyoWR4g0znGKkLiicDdw/0TSIPWoAtLiRicnopH4KZmYSaLwRO2
yg/IjLgOPW1HccXbHmjl2DJZm1MPZkneI//Op91qEhgIJbjHmYpuIu27I3taOEkAL8yUBvuJ
AhwEEAEKAAYFAlQ/8oIACgkQ0q1UgGKo5VjO0BAAhga9m0XhwSy+3OmwQ4u7Qq3D7tLPYScY
BSBUcbRYnF8tm2hNXAjzT2zNArDzCAb8QLeXKbglrz7G3vWNGZDX+sub2lJ70a5vpbUKvP2Q
UUc9vGc6G+PmaWXavqtwGwLZxVIdJs8LOSqQ2h78rxTDckNAf/j/Bh6eHZkTN4VD8QMrZSHp
9StKPSCUvP835u31a7IyN3jafby8CtcipVDktQ1QF9OUbiTRMJe0aRSgaNfJt1D5ZxMzOJwn
5yOOi+/roejU/C/srAixvgj+TqIzlVq8PWlx2ONkxI96oENlFuVbPFOokGSn73p327Cbd3zs
OsSKG/M0IfXeTAw/babhIQxlCpG4zGoIVPTtOLSD6kjfJp8HT1pRIRy44na+YOTUkFvYly0B
ar2PM6B2ciFAZDXw9Mh0W7MyTx+KoYBaTXWRrSH4VCq2SRNZDdPt2lFm/g0GD0MmOd+tKHDP
aTdvK5FqNAzOLXp2teobdO0UZ1dp4rHNGRH3EV/MYR+DNHZEYqB4UwtBTAuNKEzO7OsgDN1A
lp1mT2VgXzBfPhHyufENMBNzFNUFAcM4WSdufiH1ZH0ixJQW/TCVAdCR0OeFrdoCvOl8wn0V
IiX3HgmWtvxYjSWP1++La5DGQuuoCZvrWgxgiEcjNRHFHCAXIqWMuCul2gTS7Ht9tspAXurL
2v65AQ0EUWLZMwEIAMPF4uAI9Vld6rnbJTNLWzEVEn1Ay9yVR1IL+GHKJ2D4jfP/OFoPsoFm
zVt5lhTa8Hn0/TxuAXdDxN1uyA+ZJmxoVzWxaz4ZjBgc+ypDktUF7tcSL46CJeioCU4O90P4
J+6UBt/7KFTfP7UBGqt0c4f0xq5lSUaXhpPNBzB8m5oR5/cCYL1a6rNBCoORiC6GCVKXyF6j
BgW0itjT5wCrFhtINy9CPSm3YlwxmwxOwxPutwuWfl07wuhH8CccWo2aTPJ3AWJcDg955D+G
q3ZDKP++EsdOn6ToZ5FKjiq1yXozrJn8OPLT4wb2n6WI+DqnlwKd5TkxBHCVOKOoHGYL6N8A
EQEAAYkCPgQYAQoACQUCUWLZMwIbLgEpCRB0VcXjwM3OucBdIAQZAQoABgUCUWLZMwAKCRBV
Qy3zHM1PzXwzCACKdHE0k1DC6JHlpla0M1L/YahRuNqwiTSYW+hjmOha0m7geLt16CapEqJA
LhnBXY5h8DLNPaS7qifLnWS2bqOvcxgzALqRynFsNhzfxL++QVL7F2yzKSE/zQ0oAMaJo8Va
xZWIVR8E/wwzaWuw93CJ2B6oaJn/urzGJWdkVbLnsOXieeDL3o1aheDZtjr+F6Cx/W0+5LBX
CKRro63VTMjCjjBt2fTzdnwx1uVSpiIJAH3G8WCEW+J81wjWJLIniCtSd512jd0Bhb7BjNRm
rutKEln921WMBMu7SepCAF3PIxpPQPo/H1AVqRXU4DW278LWMY+WX/bGfjBCUhcM8nEOETsH
/jywj5YkR9hivViaZRzbILD2qEeeBWSbf8RNDkB/YS7WWRdA7FUSCh4IBr+tQURfWLKKz/vw
u1iP+BD1ywT8FtRu+tGOlYuuDX2KuIPiEN2yKXmJCgcWhhqLyuWjl67gR5yQWrnJPrQ7s3sX
KLvDsNdCH4Hd9OumV0lcYR5Hr0MT2lKb18ljJax7EoaoZYVJuxvPhssp/31cRZWGS3l0Dyhj
+SJW/PsbAXlBXUWlJzSktjLXdWWtTXXcGF3UDnCjsMN4jV6oqbHN3YK4ZrZUNSm/ZZjgoU3E
r6P0V5tFmCLazltmy11aIY4E8FZOzyaPKDGLkQwO7B2QK6J9sMlB6Sk=
=CYZf
-----END PGP PUBLIC KEY BLOCK-----";

	$gpg = new gnupg();
	$gpg->seterrormode(gnupg::ERROR_EXCEPTION);
	$info = $gpg->import($pubkey);
	$gpg->addencryptkey($info['fingerprint']);

	echo $gpg->encrypt('hello world');

});

Route::get('/', array(
	'as'    => 'index',
	'uses'  => 'HomeController@index'
));

/* Image Proxy */
Route::get('/get/image/', 'PostsController@getProxyImage');

/* Search */
Route::post('/search', 'SearchController@search');

/* Admin Panel */
Route::get('/admin', 'AdminController@index');

//Manage Content
Route::get('/admin/manage/{content_type}', 'AdminController@manage');
Route::get('/admin/create/{content_type}', 'AdminController@getCreate');
Route::get('/admin/edit/{content_type}/{content_id}', 'AdminController@getEdit');
Route::get('/admin/delete/{content_type}/{content_id}', 'AdminController@delete');

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
Route::get('/mod/delete/{content_type}/{content_id}', array('before' => 'mod', 'uses' => 'ModController@delete'));

/* User Controller */
Route::get('/user/profile', array('before' => 'auth', 'uses' => 'UsersController@self'));
Route::get('/user/settings', 'UserController@settings');
Route::get('/user/forgot-password', 'UsersController@getForgotPassword');
Route::post('/user/forgot-password', 'UsersController@postForgotPassword');
Route::get('/user/resend-activation', 'UsersController@getResend');
Route::post('/user/resend-activation/', 'UsersController@postResend');
Route::post('/user/settings/view/save', array('before' => 'auth', 'uses' => 'UsersController@viewSave'));
Route::get('/user/settings/add-key', array('before' => 'auth', 'uses' => 'UsersController@getAddGPG'));
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
Route::post('/gpg-auth', array('before' => 'auth', 'uses' => 'UsersController@gpgAuth'));
Route::get('/gpg-auth', array('before' => 'auth', 'uses' => 'UsersController@getGPGAuth'));

/*	Posts	*/
Route::post('/posts/submit', array('before' => 'auth', 'uses' => 'PostsController@submit'));
Route::post('/posts/update', array('before' => 'auth', 'uses' => 'PostsController@update'));

/*	Threads	*/
Route::get('/thread/create/{forum_id}', array('before' => 'auth', 'uses' => 'ThreadsController@create'));
Route::post('/thread/create', array('before' => 'auth', 'uses' => 'ThreadsController@submitCreate'));
Route::get('/thread/delete/{thread_id}', array('before' => 'auth', 'uses' => 'ThreadsController@delete'));

//AJAX calls
Route::get('/posts/delete/{post_id}', array('before' => 'auth', 'uses' => 'PostsController@delete'));
Route::get('/posts/get/{post_id}', array('before' => 'auth', 'uses' => 'PostsController@get'));

//Standalone Pages
Route::get('/posts/update/{post_id}', array('before' => 'auth', 'uses' => 'PostsController@getUpdatePage'));
Route::get('/posts/delete/page/{post_id}', array('before' => 'auth', 'uses' => 'PostsController@getDeletePage'));
Route::get('/posts/reply/{post_id}', array('before' => 'auth', 'uses' => 'PostsController@getReplyPage'));

//Reports
Route::get('/posts/report/{post_id}/{page_number}', array('before' => 'auth', 'uses' => 'PostsController@getReportPage'));
Route::post('/posts/report/', array('before' => 'auth', 'uses' => 'PostsController@postReport'));

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

/* Forum Structure */
Route::get('/t/{id}', array('as' => 'thread.short', 'uses' => 'ThreadsController@indexShort')); //shorthand for reaching threads.
Route::get('/{forum_id}/{forum_slug}', array('as' => 'forum.index', 'uses' => 'ForumsController@index'));
Route::get('/{forum_id}/{forum_slug}/feed', 'FeedsController@forumFeed');
Route::get('/{forum_id}/{forum_slug}/{thread_id}/{thread_slug}', array('as' => 'threadView', 'uses' => 'ThreadsController@index'));
Route::get('/{forum_id}/{forum_slug}/{thread_id}/{thread_slug}/feed', 'FeedsController@threadFeed');
Route::get('/{forum_id}/{forum_slug}/{thread_id}/{thread_slug}/{post_id}/{post_slug}', 'PostsController@index');

/* Private Messaging */

Route::controller('messages', 'MessagesController');