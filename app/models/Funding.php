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

	public static $pico = 1000000000000;

	public function thread()
	{
		return $this->belongsTo('Thread');
	}

	public function milestones()
	{
		return $this->hasMany('Milestone');
	}

	public function payouts()
	{
		return $this->hasMany('Payout');
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
			$payments = Payment::where('payment_id', $this->payment_id)->where('block_height', '>=', 0);
			$transfers = Payment::where('payment_id', $this->payment_id)->where('block_height', -2)->sum('amount');
			$refunds = Payment::where('payment_id', $this->payment_id)->where('block_height', -1)->sum('amount');
			$_funded = $payments->where('type', 'receive')->sum('amount');
			$_funded = Monero::convert($_funded - $refunds + $transfers, $this->currency);
			return $_funded;
		});
		return $funded;
	}

	public function balance()
	{
		$cache_key = $this->id . '_funding_';
		$balance = Cache::tags('thread_' . $this->thread_id)->remember($cache_key . 'balance', 0.3, function () {
			$funded = $this->funded();
			$currency = $this->currency;
			$payouts = $this->payouts()->sum('amount');

			if ($currency != 'XMR') {
				$_payouts = Monero::convert($payouts * self::$pico, $currency);
				$balance = $funded - $_payouts;
			} else {
				$balance = $funded - $payouts;
			}

			return $balance;
		});

		return $balance;
	}

	public function balancePercentage()
	{
		$cache_key = $this->id . '_funding_';
		$balance = Cache::tags('thread_' . $this->thread_id)->remember($cache_key . 'balancePercentage', 0.3, function () {
			$balance = $this->balance();
			$funded = $this->funded();
			$used = $funded - $balance;
			if($funded) {
				$percentage = (100 * $used) / $funded;
				return $percentage;
			}
			else
			{
				return 0;
			}
		});
		return $balance;
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

	// Total funds required for ongoing projects
	public static function totalRequired() {
		$total = 0;

		$funds = Funding::all();

		foreach($funds as $item)
		{
			$total += Monero::convert($item->target * self::$pico, $item->currency);
		}

		return $total;
	}

	// Total funded with the refunds taken into account
	public static function totalFunded() {

		$total = Payment::where('block_height', '>=', 0)->sum('amount');
		$total = Monero::convert($total, 'XMR');
		$total -= self::refunds();

		return $total;
	}

	public static function refunds() {
		return Payment::where('block_height', -1)->sum('amount') / self::$pico;
	}

	// Total funds available with the payouts taken into account
	public static function totalAvailable() {

		$total = Funding::totalFunded() - Payout::sum('amount');

		return $total;
	}

	public static function getDatabaseFunds() {
		$sum = Cache::remember('databaseFunds', 20, function () {
			$payments = Payment::where('block_height', '>=', 0)->sum('amount');
			$payouts = Payout::sum('amount') * 1000000000000;
			$refund = Payment::where('block_height', -1)->sum('amount');

			$result = $payments - $payouts - $refund;

			return $result / self::$pico;
		});
		return $sum;
	}

	public static function getWalletFunds() {
		$sum = Cache::remember('walletFunds', 20, function () {
			$monero = new Monero();
			return $monero->clientBalance() / self::$pico;
		});

		return $sum;
	}

	public static function isUnbalanced() {
		//check if the difference between balances is greater than the pico unit
		if(abs(self::getDatabaseFunds() - self::getWalletFunds()) > 1)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public static function refreshFunds() {
		Cache::forget('walletFunds');
		Cache::forget('databaseFunds');
	}
}