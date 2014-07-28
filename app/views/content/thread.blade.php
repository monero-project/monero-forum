@extends('master')

@section('content')
	@foreach ($posts as $post)
	<h4><strong>{{ $post->user->username }}</strong> - <small>"{{ $post->title }}"</small></h4>
	<p>{{ $post->body }}</p>
	@endforeach
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
	<div>
	<h4>Reply to this thread</h4>
		<form role="form" action="/posts/submit" method="POST">
		<input type="hidden" name="thread_id" value="{{ $thread_id }}">
		  <div class="form-group">
		    <label>Title</label>
		    <input type="text" class="form-control" name="title" placeholder="Re: {{ $post->title }}">
		  </div>
		  <div class="form-group">
		  	<label>Text</label>
		  	<textarea class="form-control" name="body" rows="6"></textarea>
		  </div>
		  <button type="submit" class="btn btn-success">Submit Reply</button>
		</form>
	</div>
@stop 