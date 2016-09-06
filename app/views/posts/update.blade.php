@extends('master')
@section('content')
{{ Breadcrumbs::addCrumb('Home', '/') }}
{{ Breadcrumbs::addCrumb(e($post->thread->forum->name), $post->thread->forum->permalink()) }}
{{ Breadcrumbs::addCrumb(e($post->thread->name), $post->thread->permalink()) }}
{{ Breadcrumbs::addCrumb('Update Post') }}
	<div class="col-lg-12 reply-body">
		@if ($post->id == $post->thread->head()->id)
		<h1>Editing thread: {{ $post->thread->name }}</h1>
		@endif
		<p class="post-meta"><a href="/user/{{ $post->user->id }}" target="_blank">{{{ $post->user->username }}}</a> posted this on {{ $post->created_at }}</p>
	</div>
	<div class="col-lg-12">
		<form role="form" method="POST" action="/posts/update">
			@if($post->id == $post->thread->head()->id)
				@if(in_array($post->thread->forum_id, Config::get('app.funding_forums')))
					<h2>Funding Options</h2>
					<div class="form-group">
						<input type="number" class="form-control" name="target" placeholder="The target goal" value="{{ $post->thread->funding->target or "" }}">
					</div>
					<div class="form-group">
						<input type="text" class="form-control" name="currency" placeholder="The currency code" value="{{ $post->thread->funding->currency or "" }}">
					</div>
					<h2>Thread Options</h2>
				@endif
			@endif
			<input type="hidden" name="post_id" value="{{ $post->id }}">
			<input type="hidden" name="thread_id" value="{{ $post->thread->id }}">
			{{ Honeypot::generate('my_name', 'my_time') }}
		  <div class="form-group">
		    <textarea name="body" class="form-control markdown-editor" rows="5">@if (Session::has('preview')){{ Input::old('body') }}@else{{ $post->body_original }}@endif</textarea>
		  </div>
		  <button name="submit" type="submit" class="btn btn-success">Save</button>
		  <button name="preview" class="btn btn-success non-js">Preview</button>
		  <a href="{{ $post->thread->permalink() }}"><button type="button" class="btn btn-danger">Back</button></a>
		</form>
	</div>
	@if (Session::has('preview'))
	<div class="row content-preview">
		<div class="col-lg-12 preview-window">
		{{ Markdown::string(Session::get('preview')) }}
		</div>
	@else
	<div class="row content-preview" style="display: none;">
		<div class="col-lg-12 preview-window">
		Hey, whenever you type something in the upper box using markdown and click <strong>preview</strong>, you will see a preview of it over here!
		</div>
	@endif
	</div>
@stop
