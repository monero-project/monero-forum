@extends('master')

@section('content')
	<div class="row category-block">    
		<div class="panel panel-default thread-block">
		  <div class="panel-heading">
		    <h3 class="panel-title"><span class="glyphicon glyphicon-comment"></span>{{{ $thread->name }}} <p class="post-meta pull-right"><span class="glyphicon glyphicon-user"></span><a href="/user/{{ $thread->head()->user->id }}" class="poster-name" target="_blank">{{{ $thread->head()->user->username }}}</a> <span class="post-date">posted this on {{ $thread->head()->created_at }}</span></p></h3>
		  </div>
		  <div class="panel-body">
			  <div class="row post-block">
				  {{ Markdown::string(e($thread->head()->body)) }}
			  </div>
		  </div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12 button-block">
		@if (Auth::check())
			<button class="btn btn-success full-width reply-thread" style="display: none;" onclick="thread_reply()">Reply to this thread</button>
			<div class="reply-box">
				<form role="form" action="/posts/submit" method="POST">
				<input type="hidden" name="thread_id" value="{{ $thread->id }}">
				  <div class="form-group">
				  	<textarea class="form-control" name="body" rows="6" placeholder="Your insightful masterpiece goes here..."></textarea>
				  </div>
				  <button type="submit" class="btn btn-success">Submit Reply</button>
				  <button type="button" onclick="cancel_thread_reply()" class="btn btn-danger reply-cancel" style="display: none;">Cancel</button>
				</form>
			</div>
		@endif
		</div>
		<div class="col-lg-12 replies-list">
			<p>Replies: <b>{{ $thread->posts()->count() - 1 }}</b>
			<span class="pull-right"><b>Hey! This page will never end! Just keep on scrolling to see more posts!</b></span></p>
			</h3>
		</div>
		<div class="col-lg-12 post-nav">
			<ul class="nav nav-tabs" role="tablist">
			  <li class="active"><a href="#">All</a></li>
			  <li><a href="#">Insightful</a></li>
			  <li><a href="#">Irrelevant</a></li>
			</ul>
		</div>
		<div id="trunk">
			{{ thread_posts($posts, $thread->id, 0) }}
		</div>
		{{ $links }}
		<hr>
		@if(isset($errors) && sizeof($errors) > 0)
		<div class="alert alert-danger alert-dismissible" role="alert">
		  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		  @foreach ($errors as $error)
		   {{{ $error }}}<br>
		  @endforeach
		</div>
		@endif
	</div>
@stop 

@section('javascript')
{{ HTML::script('js/jquery.masonry.min.js') }}
{{ HTML::script('js/jquery.infinitescroll.min.js') }}
{{ HTML::script('js/posts.js') }}
@stop