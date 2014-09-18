@extends('master')
@section('content')
{{ Breadcrumbs::addCrumb('Home', '/') }}
{{ Breadcrumbs::addCrumb($post->thread->forum->name, $post->thread->forum->permalink()) }}
{{ Breadcrumbs::addCrumb($post->thread->name, $post->thread->permalink()) }}
{{ Breadcrumbs::addCrumb('Reply') }}
	<div class="col-lg-12 reply-body">
		<p class="post-meta"><a href="/user/{{ $post->user->id }}" target="_blank">{{{ $post->user->username }}}</a> posted this on {{ $post->created_at }}</p>
		{{ Markdown::string(e($post->body)) }}
	</div>
	<hr>
	<div class="col-lg-12">
		<form role="form" method="POST" action="/posts/submit">
			<input type="hidden" name="post_id" value="{{ $post->id }}">
			<input type="hidden" name="thread_id" value="{{ $post->thread->id }}">
		  <div class="form-group">
		    <textarea name="body" class="form-control markdown-insert" rows="5">{{{ Input::old('body') }}}</textarea>
		  </div>
		  <button name="submit" type="submit" class="btn btn-success">Submit Reply</button>
		  <button name="preview" class="btn btn-success">Preview</button>
		  <a href="{{ $post->thread->permalink() }}"><button type="button" class="btn btn-danger">Back</button></a>
		</form>
	</div>
	@if (Session::has('preview'))
	<div class="row content-preview">
		<div class="col-lg-12 preview-window">
		{{ Markdown::string(Session::get('preview')) }}
		</div>
	@else
	<div class="row content-preview" style="display: none">
		<div class="col-lg-12 preview-window">
		Hey, whenever you type something in the upper box using markdown and click <strong>preview</strong>, you will see a preview of it over here!
		</div>
	@endif
	</div>
@stop