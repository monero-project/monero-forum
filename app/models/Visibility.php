<?php

class Visibility extends \Eloquent {

	protected $table = 'visibility';

	public function user() {
		return $this->belongsTo('User');
	}
	
	public function role() {
		return $this->belongsTo('Role');
	}
	
	public static function check($content_type, $content_id)
	{
		if (Auth::check())
		{
			$rules = Visibility::where('content_type', $content_type)->where('content_id', $content_id)->get();
			if ($rules)
			{
				//check if user has any of the roles listed. if yes, then it is visible.
				foreach ($rules as $rule)
				{
					$role = \Role::where('id', $rule->role_id)->get()->first();
					if (Auth::user()->hasRole($role->name))
					{
						return true;
					}
				}
			}
			return false;
		}
		else if (!Auth::check())
		{
			$rules = Visibility::where('content_type', $content_type)->where('content_id', $content_id)->get();
			if ($rules)
			{
				//check if user has any of the roles listed. if yes, then it is visible.
				foreach ($rules as $rule)
				{
					$role = \Role::where('id', $rule->role_id)->get()->first();
					if ($role->name == 'Guest')
					{
						return true;
					}
				}
			}
			return false;
		}
		else {
			return false;
		}
	}

}