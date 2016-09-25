<?php

class SpamProtectionRequest extends \Eloquent
{
	protected $fillable = [
		'key',
		'value'
	];

	protected $table = 'spamprotection_requests';


}
