<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Zizaco\Entrust\HasRole;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait, HasRole;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');
	
	public function posts() {
		return $this->hasMany('Post');
	}
	
	public function threads() {
		return $this->hasMany('Thread');
	}
	
	public function ratings() {
		return $this->hasMany('Rating', 'username', 'username');
	}
	
	public function rated() {
		return $this->hasMany('Rating', 'rated_username', 'username');
	}
	
	public function pushed_ratings() {
		return $this->hasMany('Pushed_Rating');
	}
	
	/* Relationships with Bitcoin OTC */
	
	public function otc_user() {
		return $this->hasOne('OTC_User', 'username', 'nick');
	}
	
	public function otc_ratings() {
		return $this->otc_user()->ratings();
	}
	
	public function gpg() {
		return $this->hasOne('GPG', 'username', 'nick');
	}
	
	public function votes() {
		return $this->belongsTo('Vote');
	}
	
	/* Validator */
	
	public static function validate($input) {
		$rules = array(
			'username'	=>	"required|alpha_dash|unique:users",
			'email'		=>	"required|email|unique:users",
			'password'	=>	"required|confirmed"					
		);
		return Validator::make($input, $rules);
	}
	
	/* Generators */
	
	public function profile() {
		return '<a href="/user/'.$this->id.'">'.$this->username.'</a>';
	}

}
