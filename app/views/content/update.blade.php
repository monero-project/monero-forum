@extends('master')
@section('content')
	<div class="col-lg-12 reply-body">
		<h1>Editing to post: {{ $post->title }}</h1>
		<p class="post-meta"><a href="/user/{{ $post->user->id }}" target="_blank">{{{ $post->user->username }}}</a> posted this on {{ $post->created_at }}</p>
		{{ Markdown::string(e($post->body)) }}
	</div>
	<hr>
	<div class="col-lg-12">
		<form role="form" method="POST" action="/posts/update">
			<input type="hidden" name="post_id" value="{{ $post->id }}">
			<input type="hidden" name="thread_id" value="{{ $post->thread->id }}">
		  <div class="form-group">
		    <textarea name="body" class="form-control" rows="5">{{ $post->body }}</textarea>
		  </div>
		  <button type="submit" class="btn btn-success">Save</button>
		  <a href="{{ $post->thread->permalink() }}"><button type="button" class="btn btn-danger">Back</button></a>
		</form>
	</div>
@stop