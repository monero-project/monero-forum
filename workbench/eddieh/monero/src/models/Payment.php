<?php namespace Eddieh\Monero;

class Payment extends \Eloquent {

	protected $fillable = [
		'type',
		'address',
		'payment_id',
		'amount',
		'expires_at',
		'status',
		'block_height'
	];

	protected $table = 'xmr_payments';

	public function funding() {
		return $this->belongsTo('Funding', 'payment_id', 'payment_id');
	}

}