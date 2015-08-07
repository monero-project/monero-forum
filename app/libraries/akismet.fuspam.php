<?php
// Fuspam 1.3
// F-U-Spam!
// This script is light on documentation on purpose. Go to it's home for more info on how to use it:
// http://www.whatsmyip.org/lib/fuspam-akismet-php/

// Set these values of array $comment, then call fuspam().
// Set all array values unless you are only verifying your key, then just set 'blog'

//	$comment['blog'] = "";
//	$comment['user_ip'] = "";
//	$comment['user_agent'] = "";
//	$comment['referrer'] = "";
//	$comment['permalink'] = "";
//	$comment['comment_type'] = "";
//	$comment['comment_author'] = "";
//	$comment['comment_author_email'] = "";
//	$comment['comment_author_url'] = "";
//	$comment['comment_content'] = "";

function akismet_post ($post, $user) {

	$comment['blog'] = "https://forum.getmonero.org/";
	$comment['user_ip'] = $user['ip'];
	$comment['user_agent'] = $user['agent'];
	$comment['referrer'] = $user['referrer'];
	$comment['permalink'] = $post->thread->permalink();
	$comment['comment_type'] = "post";
	$comment['comment_author'] = $post->user->username;
	$comment['comment_author_email'] = $post->user->email;
	$comment['comment_content'] = $post->body_original;

	$key = Config::get('app.akismet_key');

	return 'false';

	return fuspam($comment, "check-spam", $key);

}

function fuspam( $comment , $type , $key )
	{
	$payload = http_build_query($comment);
	
	switch ($type)
		{
		case "verify-key":
			$call = "1.1/verify-key";
			$payload = "key={$key}&blog={$comment['blog']}";
			break;
			
		case "check-spam":
			$call = "1.1/comment-check";
			break;
			
		case "submit-spam":
			$call = "1.1/submit-spam";
			break;
			
		case "submit-ham":
			$call = "1.1/submit-ham";
			break;
			
		default:
			return "Error: 'type' not recognized";
			break;
		}
	
	$curl = curl_init("http://$key.rest.akismet.com/$call");
	
	curl_setopt($curl,CURLOPT_USERAGENT,"Fuspam/1.3 | Akismet/1.11");
	curl_setopt($curl,CURLOPT_TIMEOUT,5);
	curl_setopt($curl,CURLOPT_POSTFIELDS,$payload);
	curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
	
	$i = 0;
	do
		{
		$result = curl_exec($curl);
		
		if ($result === false)
			{ sleep(1); }
		
		$i++;
		}
	while ( ($i < 6) and ($result === false) );
	
	if ($result === false)
		{ $result = "Error: Repeat Failure"; }
		
	return $result;

}