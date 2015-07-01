@extends('master')

@section('content')
{{ Breadcrumbs::addCrumb('Home', '/') }}
{{ Breadcrumbs::addCrumb(e($thread->forum->category->name), '/#category-'.$thread->forum->category->id) }}
{{ Breadcrumbs::addCrumb(e($thread->forum->name), $thread->forum->permalink()) }}
{{ Breadcrumbs::addCrumb(e($thread->name), $thread->permalink()) }}
	<div class="row category-block">    
		<div class="panel panel-default thread-block">
		  <div class="panel-heading">
		    <h3 class="panel-title"><span class="glyphicon glyphicon-comment"></span>{{{ str_limit($thread->name, 60, '[...]') }}} <p class="post-meta pull-right"><img class="profile-picture-sm" src="/uploads/profile/small_{{ $thread->head()->user->profile_picture }}"><a href="/user/{{ $thread->head()->user->username }}" class="poster-name" target="_blank">{{{ $thread->head()->user->username }}}</a> <span class="post-date">posted this on {{ $thread->head()->created_at }}</span></p></h3>
		  </div>
		  <p class="mobile-post-meta"><a href="/user/{{ $thread->head()->user->username }}" class="poster-name" target="_blank">{{{ $thread->head()->user->username }}}</a> <span class="post-date"> | {{ $thread->head()->created_at }}</span></p>
		  <div class="panel-body">
			  @if(in_array($thread->forum->id, Config::get('app.funding_forums')) && $thread->funding)
			  @include('threads.funding_block')
			  @endif
			  <div class="row post-block">
				  {{ $thread->head()->body }}
			  </div>
		  </div>
		</div>
	</div>
	@if (Auth::check())
	<div class="row thread-controls">
			<button class="btn btn-sm btn-info no-js" id="expand-all"><i class="fa fa-arrows-alt"></i> Expand All</button>
		@if(Auth::check() && !Auth::user()->subscriptions()->where('thread_id', $thread->id)->first())
			<a href="{{ URL::route('subscriptions.subscribe', [$thread->id]) }}"><button class="btn btn-sm btn-info"><span class="glyphicon glyphicon-eye-open"></span> Subscribe</button></a>
		@elseif(Auth::check() && Auth::user()->subscriptions()->where('thread_id', $thread->id)->first())
			<a href="{{ URL::route('subscriptions.unsubscribe', [$thread->id]) }}"><button class="btn btn-sm btn-warning"><span class="glyphicon glyphicon-eye-close"></span> Unsubscribe</button></a>
		@endif
		@if ($thread->user->id == Auth::user()->id || Auth::user()->hasRole('Admin'))
			<a href="/thread/delete/{{ $thread->id }}"><button class="btn btn-sm btn-danger"><span class="glyphicon glyphicon-trash"></span> Delete</button></a>
			<a href="/posts/update/{{ $thread->head()->id }}"><button class="btn btn-sm btn-danger"><span class="glyphicon glyphicon-pencil"></span> Edit</button></a>
		@endif
		@if (Auth::user()->hasRole('Admin') || Auth::user()->hasRole('Moderator'))
			<a href="/mod/move/thread/{{ $thread->id }}"><button class="btn btn-sm btn-success"><span class="glyphicon glyphicon-share-alt"></span> Move</button></a>
			<a href="/mod/delete/thread/{{ $thread->id }}"><button class="btn btn-sm btn-success"><span class="glyphicon glyphicon-trash"></span> Delete</button></a>
		@endif
	</div>
	@endif
	
	<div class="row">
		<div class="col-lg-12 button-block">
		@if (Auth::check())
			<button class="btn btn-success full-width reply-thread" style="display: none;" onclick="thread_reply()">Reply to this thread</button>
			<div class="reply-box">
				<div class="row">
					<p class="col-lg-12">
						For post formatting please use Kramdown, <a href="http://kramdown.gettalong.org/syntax.html">click here</a> for a syntax guide.
					</p>
				</div>
				<form role="form" action="/posts/submit" method="POST">
				<input type="hidden" name="thread_id" value="{{ $thread->id }}">
				  <div class="form-group">
				  	<textarea class="form-control markdown-editor" id="content-body" name="body" rows="6" placeholder="Your insightful masterpiece goes here...">{{{ Input::old('body') }}}</textarea>
				  </div>
				  <button name="submit" type="submit" class="btn btn-success">Submit</button>
				  <button name="preview" type="submit" class="btn btn-success non-js">Preview</button>
				  <button type="button" onclick="cancel_thread_reply()" class="btn btn-danger reply-cancel" style="display: none;">Cancel</button>
				</form>
			</div>
				@if (Session::has('preview'))
					<div class="row content-preview">
						<div class="col-lg-12 preview-window">
							{{ Session::get('preview') }}
						</div>
						@else
							<div class="row content-preview" style="display: none">
								<div class="col-lg-12 preview-window">
									Hey, whenever you type something in the upper box using markdown, you will see a preview of it over here!
								</div>
								@endif
							</div>
		@endif
		</div>
		<div class="col-lg-12 replies-list">
			<p>Replies: <b>{{ $thread->posts()->count() - 1 }}</b>
			<span class="pull-right"><b>Hey! This page will never end! Just keep on scrolling to see more posts!</b></span></p>
		</div>
		<div class="col-lg-12 post-nav">
			<ul class="nav nav-tabs" role="tablist">
				@if(!User::currentSort())
			        <li class="active"><a href="{{ $thread->permalink() }}">Default</a></li>
				@else
					<li><a href="{{ $thread->permalink() }}">Default</a></li>
				@endif
				@if(User::currentSort() == 'weight')
					<li class="active"><a href="?sort=weight">Weight</a></li>
				@else
					<li><a href="?sort=weight">Weight</a></li>
				@endif
				@if(User::currentSort() == 'date_desc')
					<li class="active"><a href="?sort=date_desc">Latest</a></li>
				@else
					<li><a href="?sort=date_desc">Latest</a></li>
				@endif
				@if(User::currentSort() == 'date_asc')
					<li class="active"><a href="?sort=date_asc">Oldest</a></li>
				@else
					<li><a href="?sort=date_asc">Oldest</a></li>
				@endif
			</ul>
		</div>
		<div id="trunk">
			@if ((Input::has('sort') && Input::get('sort') == 'weight') || (!Input::has('sort') && Auth::check() && Auth::user()->default_sort == 'weight'))
				{{ thread_posts($posts, $thread->id, 0) }}
			@elseif (Input::has('sort') && Input::get('sort') != 'weight' || !Input::has('sort') && Auth::check() && Auth::user()->default_sort != 'weight')
				{{ unthreaded_posts($posts, $thread->id) }}
			@else
				{{ thread_posts($posts, $thread->id, 0) }}
			@endif
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