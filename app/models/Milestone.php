<?php

class Milestone extends \Eloquent {
	protected $fillable = [
		'title',
		'description',
		'complete',
		'funding_id',
		'completed_at',
		'funds'
	];

	protected $dates = [
		'created_at',
		'updated_at',
		'completed_at'
	];

	public function funding() {
		return $this->belongsTo('Funding');
	}

	public static function percentage($funding_id) {
		$total = Milestone::total($funding_id);
		if($total) {
			$percentage = Milestone::completed($funding_id) / $total * 100;
		}
		else {
			$percentage = 0;
		}
		return $percentage;
	}

	public function fundsConverted() {
		$funds = $this->funds;
		$funded = $this->funding->funded();
		$award = ($funds * $funded) / 100;
		return $award;
	}

	public static function completed($funding_id) {
		return Milestone::where('funding_id', $funding_id)->where('complete', 1)->count();
	}

	public static function total($funding_id) {
		return Milestone::where('funding_id', $funding_id)->count();
	}
}