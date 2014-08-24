@extends('master')
@section('content')
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
	  <div class="form-group">
	    <label>Description</label>
	    <textarea class="form-control" placeholder="Why are you flagging this post?" name="comment"></textarea>
	  </div>
	  <button type="submit" class="btn btn-default btn-success">Submit</button>
	</form>
</div>
@stop