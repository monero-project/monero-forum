<?php

function get_pubkey($key_id, $retry = false)
{
	/*
	|	-1: No results found.
	|	-2: Error handling request. [Wrong key format probably]
	|	-3: Unknown error. Might be a weird response, a timeout or server down.
	*/
	
	$pubkey = @file_get_contents('http://pgp.mit.edu/pks/lookup?op=get&search=0x'.$key_id); //prevent from file_get_contents from erroring out and screwing up the registration proccess.
	
	if (str_contains($pubkey, 'No results found'))
	{
		$pubkey = @file_get_contents('http://hkps.pool.sks-keyservers.net/pks/lookup?op=get&search=0x'.$key_id); //prevent from file_get_contents from erroring out and screwing up the registration proccess.
	}
	if (str_contains($pubkey, 'No results found'))
	{
		return -1;
	}
	else if (str_contains($pubkey, 'Error handling request'))
	{
		return -2;
	}
	
	exit (var_dump($pubkey));
	
	//give it a couple of tries before showing an error and asking to try again.
	if ($pubkey === false)
	{
		if ($retry && $retry >= Config::get('app.max_gpg_retry'))
			return -3;
		else if (!$retry)
			return get_pubkey($key_id, 1);
		else
			return get_pubkey($key_id, ++$retry);
	}
	else
		return $pubkey;
}