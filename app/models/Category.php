<?php

class Category extends \Eloquent {
	protected $fillable = [];
	
	public function forums() {
		return $this->hasMany('Forum');
	}
}