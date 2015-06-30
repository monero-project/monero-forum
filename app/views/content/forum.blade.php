@extends('master')

@section('content')
{{ Breadcrumbs::addCrumb('Home', '/') }}
{{ Breadcrumbs::addCrumb(e($forum->category->name), '/#category-'.$forum->category->id) }}
{{ Breadcrumbs::addCrumb(e($forum->name), $forum->permalink()) }}
@if (Visibility::check('forum', $forum->id))
<div class="row category-block">   
<div class="panel panel-default">
  <div class="panel-heading">
    <h1 class="panel-title"><span class="glyphicon glyphicon-list"></span> {{ $forum->name }} <a class="pull-right normal-create" href="/thread/create/{{ $forum->id }}"><button class="btn btn-xs create-thread btn-primary pull-right">Create a Thread</button></a>
    <a href="/users/action/allread/{{ $forum->id }}" alt="Mark forum as read" class="pull-right normal-create"><button class="btn btn-xs create-thread btn-primary pull-right mark-read">Mark as Read</button></a>
	</h1>
  </div>
  <div class="row mobile-create">
	  <a href="/thread/create/{{ $forum->id }}"><button class="btn full-width btn-success">Create a Thread</button></a>
  </div>
  <div class="panel-body thread-list">
    @foreach ($threads as $thread)
    <div class="row">
	    <div class="col-md-6">
	    	@if ($thread->moved && $forum->id != $thread->forum->id)
	    	<a class="thread-title" alt="{{{ $thread->name }}}" data-toggle="tooltip" data-placement="top" data-original-title="{{{ $thread->name }}}" href="/{{ $thread->forum->id }}/{{ $thread->forum->slug() }}/{{ $thread->id }}/{{ $thread->slug() }}"><small>{{{ str_limit('Moved to:'. $thread->forum->name, 50, ' [...]') }}}</small>
	    	@else
	    	    @if ( $thread->new_posts )
	    	    <img data-toggle="tooltip" data-placement="top" data-original-title="{{{ $thread->unread_posts }}}" src="//static.getmonero.org/images/icon_thread_new.png">
	            @else
	    	    <img src="//static.getmonero.org/images/icon_thread.png">
	    	    @endif
	    	<a class="thread-title" data-toggle="tooltip" data-placement="top" data-original-title="{{{ $thread->name }}}" href="/{{ $forum->id }}/{{ $forum->slug() }}/{{ $thread->id }}/{{ $thread->slug() }}">
	    	@endif {{{ str_limit($thread->name, 50, ' [...]') }}}</a>
	    </div>
		<div class="col-md-4">
		<p>Author: <b><a class="board-meta" href="/user/{{ $thread->user->username }}">{{ $thread->user->username }}</a></b>, {{ $thread->created_at }}</p>
		</div>
		<div class="col-md-2 thread-replies">
			<p>Replies: <b>{{ $thread->posts()->count() - 1}}</b></p>
		</div>
	    @if($thread->funding)
	    @include('content.forum_funding_block')
		@endif
	</div>
	@endforeach
  </div>
</div>
</div>
<div class="post-links">
	{{ $threads->links() }}
</div>
@else
{{ App::abort(404); }}
@endif
@stop