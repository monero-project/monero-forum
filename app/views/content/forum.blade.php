@extends('master')

@section('content')
{{ Breadcrumbs::addCrumb('Home', '/') }}
{{ Breadcrumbs::addCrumb($forum->name, $forum->permalink()) }}
@if (Visibility::check('forum', $forum->id))
<div class="row category-block">   
<div class="panel panel-default">
  <div class="panel-heading">
    <h1 class="panel-title"><span class="glyphicon glyphicon-list"></span> {{ $forum->name }} <a class="pull-right normal-create" href="/thread/create/{{ $forum->id }}"><button class="btn btn-xs create-thread btn-primary pull-right">Create a Thread</button></a>
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
	    	<a class="thread-title" href="/{{ $thread->forum->id }}/{{ $thread->forum->slug() }}/{{ $thread->id }}/{{ $thread->slug() }}"><small>Moved to: {{ $thread->forum->name }}</small>
	    	@else
	    	<a class="thread-title" href="/{{ $forum->id }}/{{ $forum->slug() }}/{{ $thread->id }}/{{ $thread->slug() }}">
	    	@endif {{ $thread->name }}</a>
	    </div>
		<div class="col-md-4">
		<p>Author: <b><a class="board-meta" href="/user/{{ $thread->user->username }}">{{ $thread->user->username }}</a></b>, {{ $thread->created_at }}</p>
		</div>
		<div class="col-md-2 thread-replies">
			<p>Replies: <b>{{ $thread->posts()->count() - 1 }}</b></p>
		</div>
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