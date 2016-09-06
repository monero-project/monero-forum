<?php

use Carbon\Carbon;

class Thread extends \Eloquent
{
	protected $fillable = [
		'name',
		'user_id',
		'forum_id',
		'body'
	];
	protected $softDelete = true;
	use SoftDeletingTrait;

	public function user()
	{
		return $this->belongsTo('User');
	}

	public function subscriptions()
	{
		return $this->hasMany('Subscription');
	}

	public function forum()
	{
		return $this->belongsTo('Forum');
	}

	public function posts()
	{
		return $this->hasMany('Post');
	}

	public function head()
	{
		return Post::find($this->post_id);
	}

	public function post()
	{
		return $this->belongsTo('Post');
	}

	public function views()
	{
		return $this->hasMany('ThreadView');
	}

	public function funding()
	{
		return $this->hasOne('Funding');
	}

	public function slug()
	{
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

	public function permalink()
	{
		return "http://" . $_SERVER['HTTP_HOST'] . "/" . $this->forum->id . "/" . $this->forum->slug() . "/" . $this->id . "/" . $this->slug();
	}

	public static function validate($input)
	{
		$rules = array(
			'forum_id' => 'required|exists:forums,id',
			'user_id' => 'required|exists:users,id',
			'name' => 'required',
			'body' => 'required',
			'my_name'  => 'honeypot',
			'my_time'  => 'required|honeytime:5'
		);

		$messages = array(
			'name.required' => 'A thread title is required!',
			'body.required' => 'Your thread needs some content!'
		);

		return Validator::make($input, $rules, $messages);
	}

	public function getNewPostsAttribute()
	{
		$thread = $this;
		if (Auth::check()) {
			$threadView = ThreadView::where('user_id', Auth::user()->id)->where('thread_id', $thread->id)->orderBy('updated_at', 'DESC')->first();
			$threadPost = $thread->posts()->orderBy('created_at', 'DESC')->first();
			if (
				($threadView
					&& $threadPost
					&& $threadPost->updated_at > $threadView->updated_at)
				||
				!$threadView
			) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}

	}

	public function getUnreadPostsAttribute()
	{
		$thread = $this;
		if (Auth::check() && ThreadView::where('user_id', Auth::user()->id)->where('thread_id', $thread->id)->orderBy('updated_at', 'DESC')->first()) {
			$lastView = ThreadView::where('user_id', Auth::user()->id)->where('thread_id', $thread->id)->first();
			$lastView = $lastView->updated_at;
			$postCount = $thread->posts()->where('updated_at', '>', $lastView)->count();
			return $postCount;
		} else {
			return 0;
		}
	}

	public function latest_post() {
		return $this->posts()->orderBy('created_at', 'DESC')->first();
	}

	public function getAverageWeightAttribute() {
		if(Auth::check())
		{
			$user = Auth::user();
			$key = 'average_weight_'.$this->id.'_'.$user->id;
			$tags = ['thread_'.$this->id, 'user_'.$user->id];
		}
		else
		{
			$key = 'average_weight_'.$this->id.'_guest';
			$tags = ['thread_'.$this->id];
		}

		$thread = $this;

		$average = Cache::tags($tags)->remember($key, 30, function() use ($thread)
		{
			$_average = 0;

			foreach($thread->posts as $post)
			{
				$_average += $post->weight;
			}

			$total = $thread->posts->count();

			if($total) {
				$_average = $_average / $total;
				return $_average;
			}
			else {
				return Config::get('app.hidden_weight');
			}
		});

		return $average;
	}

	public static function userCanSubmitThread($user) {

		//get no. of users' threads created today if he registered in the past app.thread_total_days_limit days
		if (User::isNew(Auth::user())) {

			$threadNumber = Thread::where('user_id', '=', $user->id)
			                   ->whereDate('created_at', '=', Carbon::today()->toDateString())
						       ->count();

			//check if daily limit reached
			if ($threadNumber < Config::get('app.thread_daily_limit')) return true; else return false;

	    } else {

			//if user not new then he is allowed to post new thread
			return true;

		}

	}

}
