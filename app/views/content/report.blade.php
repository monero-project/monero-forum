@extends('master')
@section('content')
{{ Breadcrumbs::addCrumb('Home', '/') }}
{{ Breadcrumbs::addCrumb($post->thread->forum->name, $post->thread->forum->permalink()) }}
{{ Breadcrumbs::addCrumb($post->thread->name, $post->thread->permalink()) }}
{{ Breadcrumbs::addCrumb('Report') }}
<div class="row report-post">
	<div class="col-md-12">
		{{ Markdown::string(e($post->body)) }}
	</div>
	<div class="col-md-12">
		Posted by: {{{ $post->user->username }}}
	</div>
</div>
<div class="row">
	<form role="form" action="/posts/report" method="POST">
	<input type="hidden" name="post_id" value="{{ $post->id }}">
	<input type="hidden" name="page" value="{{ $page_number }}">
	  <div class="form-group">
	    <label>Description</label>
	    <textarea class="form-control" placeholder="Why are you flagging this post?" name="comment"></textarea>
	  </div>
	  <button type="submit" class="btn btn-default btn-success">Submit</button>
	</form>
</div>
@stop