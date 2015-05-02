<?php

use Eddieh\Monero\Payment;
use Eddieh\Monero\Monero;

class Funding extends \Eloquent
{
	protected $table = 'funding';

	protected $fillable = [
		'payment_id',
		'funded',
		'target',
		'currency',
		'thread_id',
		'id'
	];

	public function thread()
	{
		return $this->belongsTo('Thread');
	}

	public function percentage()
	{
		$cache_key = $this->payment_id . '_funding_';
		$percentage = Cache::tags('thread_' . $this->thread_id)->rememberForever($cache_key . 'percentage', function () {
			//TODO: calculate real percentage
			$value = ($this->funded() / $this->target) * 100;
			return $value;
		});
		return $percentage;
	}

	public function contributions()
	{
		$cache_key = $this->payment_id . '_funding_';
		$contributions = Cache::tags('thread_' . $this->thread_id)->rememberForever($cache_key . 'contributions', function () {
			return Payment::where('payment_id', $this->payment_id)->count();
		});
		return $contributions;
	}

	public function funded()
	{
		$cache_key = $this->payment_id . '_funding_';
		$funded = Cache::tags('thread_' . $this->thread_id)->rememberForever($cache_key . 'funded', function () {
			$payments = Payment::where('payment_id', $this->payment_id);
			$_funded = $payments->where('type', 'receive')->sum('amount');
			$_funded = Monero::convert($_funded, $this->currency);
			return $_funded;
		});
		return $funded;
	}

	//returns the currency symbol
	public function symbol()
	{
		switch ($this->currency) {
			case 'USD':
				return '$';
			default :
				return '$';
		}
	}
}