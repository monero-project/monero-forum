<?php

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
			'body' => 'required'
		);

		$messages = array(
			'name.required'      => 'A thread title is required!',
			'body.required'      => 'Your thread needs some content!'
		);

		return Validator::make($input, $rules, $messages);
	}

	public function getNewPostsAttribute()
	{
		$thread = $this;
		if (
			Auth::check()
			&&
			(
				(
					ThreadView::where('user_id', Auth::user()->id)->where('thread_id', $thread->id)->orderBy('updated_at', 'DESC')->first()
					&&
					$thread->posts()->orderBy('created_at', 'DESC')->first()->updated_at > ThreadView::where('user_id', Auth::user()->id)->where('thread_id', $thread->id)->first()->updated_at
				)
				||
				!ThreadView::where('user_id', Auth::user()->id)->where('thread_id', $thread->id)->orderBy('updated_at', 'DESC')->first()
			)
		) {
			return ThreadView::where('user_id', Auth::user()->id)->where('thread_id', $thread->id)->orderBy('updated_at', 'DESC')->first();
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
}