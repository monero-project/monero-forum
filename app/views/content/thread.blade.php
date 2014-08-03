@extends('master')

@section('content')
	<div class="col-lg-12">
	<h1>{{{ Thread::findOrFail($thread_id)->name }}}</h1>
	<p class="post-meta"><a href="/user/{{ $posts[0]->user->id }}" target="_blank">{{{ $posts[0]->user->username }}}</a> posted this on {{ $posts[0]->created_at }}</p>
	{{ Markdown::string(e($posts[0]->body)) }}
	<hr>
	@if (Auth::check())
	<button type="submit" class="btn btn-success full-width reply-thread" onclick="thread_reply()">Reply to this thread</button>
	@endif
	<div class="reply-box" style="display: none;">
		<form role="form" action="/posts/submit" method="POST">
		<input type="hidden" name="thread_id" value="{{ $thread_id }}">
		  <div class="form-group">
		    <input type="text" class="form-control" name="title" value="Re: {{ Thread::findOrFail($thread_id)->name }}">
		  </div>
		  <div class="form-group">
		  	<textarea class="form-control" name="body" rows="6" placeholder="Your insightful masterpiece goes here..."></textarea>
		  </div>
		  <button type="submit" class="btn btn-success">Submit Reply</button>
		  <button type="button" onclick="cancel_thread_reply()" class="btn btn-danger reply-cancel">Cancel</button>
		</form>
	</div>
	</div>
	{{ NULL; unset($posts[0]) }}
	<div class="col-lg-12 replies-list">
		<h3 class="pull-left">Replies: {{ Thread::find($thread_id)->posts()->count() }}</h3>
		<button class="btn btn-default btn-sm pull-right"><span class="glyphicon glyphicon-expand"></span> Load More</button>
		<button class="btn btn-default btn-sm pull-right" onclick="thread_refresh({{ $thread_id }})"><span class="glyphicon glyphicon-refresh"></span> Refresh</button>
	</div>
	{{ display_posts(NULL, $thread_id, 0) }}
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
{{ HTML::script('js/posts.js') }}
@stop