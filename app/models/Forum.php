<?php

class Forum extends \Eloquent {
	protected $fillable = [];
	
	public function category() {
		return $this->belongsTo('Category');
	}
	
	public function threads() {
		return $this->hasMany('Thread');
	}
	
	public function slug() {
		$slug = $this->name;	
		
		$slug = preg_replace('~[^\\pL\d]+~u', '-', $slug);
		$slug = trim($slug, '-');
		$slug = iconv('utf-8', 'us-ascii//TRANSLIT', $slug);
		$slug = strtolower($slug);
		$slug = preg_replace('~[^-\w]+~', '', $slug);
			
		if (empty($slug)) {
	    	return 'n-a';
		}
			
		return $slug;
	}
	
	public function permalink() {
		return "http://".$_SERVER['HTTP_HOST']."/".$this->slug()."/".$this->id;
	}
	
}