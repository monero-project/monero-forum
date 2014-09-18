@extends('master')

@section('content')
{{ Breadcrumbs::addCrumb('Home', '/') }}
{{ Breadcrumbs::addCrumb($thread->forum->name, $thread->forum->permalink()) }}
{{ Breadcrumbs::addCrumb($thread->name, $thread->permalink()) }}
	<div class="row category-block">    
		<div class="panel panel-default thread-block">
		  <div class="panel-heading">
		    <h3 class="panel-title"><span class="glyphicon glyphicon-comment"></span>{{{ $thread->name }}} <p class="post-meta pull-right"><img class="profile-picture-sm" src="/uploads/profile/small_{{ $thread->head()->user->profile_picture }}"><a href="/user/{{ $thread->head()->user->username }}" class="poster-name" target="_blank">{{{ $thread->head()->user->username }}}</a> <span class="post-date">posted this on {{ $thread->head()->created_at }}</span></p></h3>
		  </div>
		  <p class="mobile-post-meta"><a href="/user/{{ $thread->head()->user->username }}" class="poster-name" target="_blank">{{{ $thread->head()->user->username }}}</a> <span class="post-date"> | {{ $thread->head()->created_at }}</span></p>
		  <div class="panel-body">
			  <div class="row post-block">
				  {{ Markdown::string(e($thread->head()->body)) }}
			  </div>
		  </div>
		</div>
	</div>
	@if (Auth::check())
	<div class="row thread-controls">
		@if ($thread->user->id == Auth::user()->id)
			<a href="/thread/delete/{{ $thread->id }}"><button class="btn btn-sm btn-danger"><span class="glyphicon glyphicon-trash"></span> Delete</button></a>
			<a href="/posts/update/{{ $thread->head()->id }}"><button class="btn btn-sm btn-danger"><span class="glyphicon glyphicon-pencil"></span> Edit</button></a>
		@endif
	</div>
	@endif
	
	<div class="row">
		<div class="col-lg-12 button-block">
		@if (Auth::check())
			<button class="btn btn-success full-width reply-thread" style="display: none;" onclick="thread_reply()">Reply to this thread</button>
			<div class="reply-box">
				<form role="form" action="/posts/submit" method="POST">
				<input type="hidden" name="thread_id" value="{{ $thread->id }}">
				  <div class="form-group">
				  	<textarea class="form-control" id="content-body" name="body" rows="6" placeholder="Your insightful masterpiece goes here...">{{{ Input::old('body') }}}</textarea>
				  </div>
				  <button name="submit" type="submit" class="btn btn-success">Submit</button>
				  <button name="preview" type="submit" class="btn btn-success preview-button">Preview</button>
				  <button type="button" onclick="cancel_thread_reply()" class="btn btn-danger reply-cancel" style="display: none;">Cancel</button>
				</form>
				@if (Session::has('preview'))
				<div class="row content-preview">
					<div class="col-lg-12 preview-window">
					{{ Markdown::string(Session::get('preview')) }}
					</div>
				@else
				<div class="row content-preview" style="display: none">
					<div class="col-lg-12 preview-window">
					Hey, whenever you type something in the upper box using markdown, you will see a preview of it over here!
					</div>
				@endif
				</div>
			</div>
		@endif
		</div>
		<div class="col-lg-12 replies-list">
			<p>Replies: <b>{{ $thread->posts()->count() - 1 }}</b>
			<span class="pull-right"><b>Hey! This page will never end! Just keep on scrolling to see more posts!</b></span></p>
			</h3>
		</div>
		<div class="col-lg-12 post-nav">
		<!--
			<ul class="nav nav-tabs" role="tablist">
			  <li class="active"><a href="#">All</a></li>
			  <li><a href="#">Insightful</a></li>
			  <li><a href="#">Irrelevant</a></li>
			</ul>
		-->
		</div>
		<div id="trunk">
			{{ thread_posts($posts, $thread->id, 0) }}
		</div>
		<div class="post-links">
			{{ $links }}
		</div>
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
@if(!Input::has('noscroll'))
{{ HTML::script('js/jquery.infinitescroll.min.js') }}
@endif
{{ HTML::script('js/posts.js') }}
{{ HTML::script('js/js-markdown-extra.js') }}
{{ HTML::script('js/preview.js') }}
{{ HTML::script('js/rangyinputs-jquery-1.1.2.min.js') }}
<script type="text/javascript">
    $(function () {
        $("[data-toggle='tooltip']").tooltip();
    });
</script>
@stop