@extends('master')

@section('content')
	@foreach ($posts as $post)
	<h4><strong>{{ $post->user->username }}</strong> - <small>"{{ $post->title }}"</small></h4>
	<p>{{ $post->body }}</p>
	@endforeach
	{{ $posts->links() }}
	<hr>
	<div>
	<h4>Reply to this thread</h4>
		<form role="form" action="/post/submit" method="post">
		  <div class="form-group">
		    <label for="exampleInputEmail1">Title</label>
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