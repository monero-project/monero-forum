@extends('master')

@section('content')
	<div class="col-lg-12">
	<h1>{{{ $thread->name }}}</h1>
	<p class="post-meta"><a href="/user/{{ $posts[0]->user->id }}" target="_blank">{{{ $thread->head()->user->username }}}</a> posted this on {{ $thread->head()->created_at }}</p>
	{{ Markdown::string(e($thread->head()->body)) }}
	<hr>
	@if (Auth::check())
	<button class="btn btn-success full-width reply-thread" style="display: none;" onclick="thread_reply()">Reply to this thread</button>
	@endif
	<div class="reply-box">
		<form role="form" action="/posts/submit" method="POST">
		<input type="hidden" name="thread_id" value="{{ $thread->id }}">
		  <div class="form-group">
		    <input type="text" class="form-control" name="title" value="Re: {{ $thread->name }}">
		  </div>
		  <div class="form-group">
		  	<textarea class="form-control" name="body" rows="6" placeholder="Your insightful masterpiece goes here..."></textarea>
		  </div>
		  <button type="submit" class="btn btn-success">Submit Reply</button>
		  <button type="button" onclick="cancel_thread_reply()" class="btn btn-danger reply-cancel" style="display: none;">Cancel</button>
		</form>
	</div>
	</div>
	<div class="col-lg-12 replies-list">
		<h3 class="pull-left">Replies: {{ $thread->posts()->count() }}</h3>
	</div>
	<div id="trunk">
		{{ thread_posts($posts, $thread->id, 0) }}
	</div>
	{{ $posts->links() }}
	<hr>
	@if(isset($errors) && sizeof($errors) > 0)
	<div class="alert alert-danger alert-dismissible" role="alert">
	  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	  @foreach ($errors as $error)
	   {{{ $error }}}<br>
	  @endforeach
	</div>
	@endif
@stop 

@section('javascript')
{{ HTML::script('js/jquery.infinitescroll.min.js') }}
{{ HTML::script('js/posts.js') }}
@stop