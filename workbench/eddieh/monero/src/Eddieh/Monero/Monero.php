<?php namespace Eddieh\Monero;

use Config;
use Log;
use Funding;

class Monero
{

	public $expire;
	public $wallet;
	public $address;
	public $alias;

	function __construct()
	{
		$this->expire = Config::get('monero::expire');
		$this->wallet = Config::get('monero::wallet');
		$this->address = Config::get('monero::address');
		$this->alias = Config::get('monero::alias');
	}

	public static function generatePaymentID($var = false)
	{
		if (!$var) {
			$payment_id = bin2hex(openssl_random_pseudo_bytes(32));
			$check = Payment::where('payment_id', $payment_id)->count();
			while ($check != 0) {
				$payment_id = bin2hex(openssl_random_pseudo_bytes(32));
				$check = Payment::where('payment_id', $payment_id)->count();
			}
		} else {
			$payment_id = hash('sha256', $var);
		}

		return $payment_id;
	}

	public function receive($xmr, $payment_id_var = false)
	{
		$amount = $xmr * 1000000000000;

		$payment_id = $this->generatePaymentID($payment_id_var);

		$expire = date("Y-m-d H:i", strtotime("now " . $this->expire));

		$payment = Payment::create([
			'type' => 'receive',
			'payment_id' => $payment_id,
			'amount' => $amount,
			'status' => 'pending',
			'expires_at' => $expire
		]);

		$payment->address = $this->address;
		$payment->openalias = $this->alias;

		return $payment;
	}

	public function transfer($address, $xmr = 0 /* amount in XMR*/)
	{
		$amount = $xmr * 1000000000000;

		if ($amount == 0 || !Monero::validateAddress($address)) {
			return false;
		}

		$payment = Payment::create([
			'type' => 'transfer',
			'address' => $address,
			'amount' => $amount,
			'status' => 'pending'
		]);

		return $payment;

	}

	public function clientBalance() {
		$data = [
			'jsonrpc' => '2.0',
			'method' => 'getbalance',
			'id' => 'phpmonero',
			'params' => []
		];

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "http://".$this->wallet."/json_rpc");
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_ENCODING, 'Content-Type: application/json');
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_VERBOSE, true);

		$server_output = curl_exec($ch);

		$result = json_decode($server_output, true);

		return $result['result']['balance'];

	}

	function clientReceive()
	{
		$now = date("Y-m-d H:i", strtotime("now"));

		//get all payments currently in the DB

		$pending = Payment::where('status', 'complete')->where('type', 'receive')->orderBy('block_height', 'DESC');

		//get the payment with the highest block_height

		$ch = curl_init();

		if ($pending->get()->count()) {
			//get the highest block height
			$highest_block = $pending->first()->block_height;

			//scan from the highest block.
			$data = [
				'jsonrpc' => '2.0',
				'method' => 'get_bulk_payments',
				'id' => 'phpmonero',
				'params' => [
					'payment_ids' => [],
					'min_block_height' =>  $highest_block
				]
			];
		}
		else {
			//get all the payments
			$data = [
				'jsonrpc' => '2.0',
				'method' => 'get_bulk_payments',
				'id' => 'phpmonero',
				'params' => [
					'payment_ids' => []
				]
			];
		}

		$funding_threads = Funding::all();

		//add the payment_ids from the funding table to the params
		foreach($funding_threads as $payment)
		{
			$data['params']['payment_ids'][] = $payment->payment_id;
		}

		curl_setopt($ch, CURLOPT_URL, "http://".$this->wallet."/json_rpc");
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_ENCODING, 'Content-Type: application/json');
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_VERBOSE, true);

		//send the query to the RPC wallet.
		$server_output = curl_exec($ch);
		echo 'Sending Data: '.json_encode($data).PHP_EOL;
		$result = json_decode($server_output, true);
		echo 'Received Data: '.$server_output.PHP_EOL;
		$payments = array();
		if(isset($result["result"]["payments"]) && $result["result"]["payments"]) {
			foreach($result["result"]["payments"] as $payment)
			{
				//check if payment with block height exists
				$duplicate = Payment::where('block_height', $payment["block_height"])
								->where('payment_id', $payment["payment_id"])
								->where('amount', $payment["amount"])
								->first();
				if(!$duplicate) {
					Payment::create([
						'type' => 'receive',
						'payment_id' => $payment["payment_id"],
						'amount' => $payment["amount"],
						'status' => 'complete',
						'block_height' => $payment["block_height"]
					]);
				}
			}
		}
		curl_close($ch);
	}

	function clientTransfer($payment_id_var = false, $mixin = 3)
	{
		$pending = Payment::where('status', 'pending')->where('type', 'transfer')->get();

		if (count($pending)) {

			$payment_id = $this->generatePaymentID($payment_id_var);

			$ch = curl_init();

			$data = [
				'jsonrpc' => '2.0',
				'method' => 'transfer',
				"id" => "phpmonero",
				"params" => [
					'destinations' => [],
					'payment_id' => $payment_id,
					'mixin' => $mixin,
					'unlock_time' => 0
				]
			];

			foreach ($pending as $payment) {
				$data["params"]["destinations"][] = [
					'amount' => $payment->amount,
					'address' => $payment->address
				];
			}

			curl_setopt($ch, CURLOPT_URL, "http://" . $this->wallet . "/json_rpc");
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_ENCODING, 'Content-Type: application/json');
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$server_output = curl_exec($ch);

			if (curl_error($ch) != "") {
				return false;
			} else {
				foreach($pending as $payment)
				{
					$payment->status = 'complete';
					$payment->save();
				}
				return $pending;
			}
		}
		else {
			return false;
		}
	}

	public static function sort($key)
	{
		return function ($a, $b) use ($key) {
			return strnatcmp($a[$key], $b[$key]);
		};
	}

	public static function validateAddress($address)
	{
		if (
			substr($address, 0) != '4' ||
			!preg_match('/([0-9]|[A-B])/', substr($address, 1)) ||
			strlen($address) != 95
		) {
			return false;
		} else {
			return true;
		}
	}

	public static function convert($amount, $code = 'USD') {
		//convert XMR
		$amount = $amount / 1000000000000;
		if($code == 'XMR')
			return $amount;
		$values = file_get_contents('https://moneropric.es/fiat.json');
		$values = json_decode($values);
		foreach($values as $value) {
			if($value->code == $code)
			{

				return $amount / $value->{'xmr-rate'};

			}
		}
		return false;
	}

}