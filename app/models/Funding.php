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

	public function milestones()
	{
		return $this->hasMany('Milestone');
	}

	public function percentage()
	{
		$cache_key = $this->id . '_funding_';
		$percentage = Cache::tags('thread_' . $this->thread_id)->rememberForever($cache_key . 'percentage', function () {
			$value = ($this->funded() / $this->target) * 100;
			return $value;
		});
		return $percentage;
	}

	public function contributions()
	{
		$cache_key = $this->id . '_funding_';
		$contributions = Cache::tags('thread_' . $this->thread_id)->rememberForever($cache_key . 'contributions', function () {
			return Payment::where('payment_id', $this->payment_id)->where('amount', '<>', 0)->count();
		});
		return $contributions;
	}

	public function funded()
	{
		$cache_key = $this->id . '_funding_';
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
			case 'GBP':
				return '£';
			case 'EUR':
				return '€';
			default :
				return $this->currency;
		}
	}
}