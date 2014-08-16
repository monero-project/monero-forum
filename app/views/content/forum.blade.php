@extends('master')

@section('content')
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
	    <div class="col-md-1 thread-col thread-icon">
	    </div>
	    <div class="col-md-5">
	    	<a class="thread-title" href="/{{ $forum->slug() }}/{{ $forum->id }}/{{ $thread->slug() }}/{{ $thread->id }}">{{ $thread->name }}</a>
	    </div>
		<div class="col-md-4">
		<p>Author: <b>{{ $thread->user->username }}</b>, {{ $thread->created_at }}</p>
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
@stop