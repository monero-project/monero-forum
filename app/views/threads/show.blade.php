@extends('master')

@section('description')
	<meta name="description" content="{{ str_limit(trim(preg_replace('/\s\s+/', ' ', strip_tags($thread->head()->body))), 155, '[...]')  }}" />
@stop

@section('content')
{{ Breadcrumbs::addCrumb('Home', '/') }}
{{ Breadcrumbs::addCrumb(e($thread->forum->category->name), '/#category-'.$thread->forum->category->id) }}
{{ Breadcrumbs::addCrumb(e($thread->forum->name), $thread->forum->permalink()) }}
{{ Breadcrumbs::addCrumb(e($thread->name), $thread->permalink()) }}
	<div class="row category-block">    
		<div class="panel panel-default thread-block">
		  <div class="panel-heading">
		    <h3 class="panel-title"><span class="glyphicon glyphicon-comment"></span>{{{ str_limit($thread->name, 60, '[...]') }}} <p class="post-meta pull-right"><img class="profile-picture-sm" src="/uploads/profile/small_{{ $thread->head()->user->profile_picture }}"><a href="/user/{{ $thread->head()->user->username }}" class="poster-name" target="_blank">{{{ $thread->head()->user->username }}}</a> <span class="post-date" data-toggle="tooltip" data-placement="top" data-original-title="{{{ $thread->head()->created_at }}}">posted this {{ $thread->head()->created_at->diffForHumans() }}</span></p></h3>
		  </div>
		  <p class="mobile-post-meta"><a href="/user/{{ $thread->head()->user->username }}" class="poster-name" target="_blank">{{{ $thread->head()->user->username }}}</a> <span class="post-date"> | {{ $thread->head()->created_at->diffForHumans() }}</span></p>
		  <div class="panel-body">
			  @if(in_array($thread->forum->id, Config::get('app.funding_forums')) && $thread->funding)
			  @include('threads.includes.funding')
			  @endif
			  <div class="row post-block video-integration">
				  {{ $thread->head()->body }}
			  </div>
				@include('threads.includes.controls')
				<span class="reply-count"><i class="fa fa-comments-o"></i> Replies: <strong>{{ $thread->posts->count() - 1 }}</strong></span>
		  </div>
		</div>
	</div>
	<div class="row">
		@if (Auth::check())
			<div class="reply-box">
				<div class="media markdown-toolbar">
					<div class="pull-left">
						<img class="media-object reply-box-avatar" src="/uploads/profile/small_{{ Auth::user()->profile_picture }}" alt="{{ Auth::user()->username }} Profile Picture">
					</div>
					<div class="media-body">
						<form role="form" action="/posts/submit" method="POST">
							<input type="hidden" name="thread_id" value="{{ $thread->id }}">
							<div class="form-group">
								<textarea class="form-control markdown-editor" id="content-body" name="body" rows="2" placeholder="Your insightful masterpiece goes here...">{{{ Input::old('body') }}}</textarea>
							</div>
							<div class="pull-left">
								<p>For post formatting please use Kramdown, <a href="http://kramdown.gettalong.org/syntax.html">click here</a> for a syntax guide.</p>
							</div>
							<div class="markdown-form-buttons">
								<button name="submit" type="submit" class="btn btn-success">Reply</button>
								<button name="preview" type="submit" class="btn btn-primary non-js">Preview</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			@if (Session::has('preview'))
				<div class="row content-preview">
					<div class="col-lg-12 preview-window">
						{{ Session::get('preview') }}
					</div>
				</div>
			@endif
		@endif
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