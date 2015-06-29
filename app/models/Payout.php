<?php

class Payout extends \Eloquent
{
	protected $fillable = [
		'funding_id',
		'amount'
	];

	public function funding() {
		return $this->belongsTo('Funding');
	}
}