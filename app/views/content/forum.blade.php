@extends('master')

@section('content')
@foreach ($threads as $thread)
<h4><strong><a href="/{{ $forum_slug }}/{{ $forum_id }}/{{ $thread->slug() }}/{{ $thread->id }}">{{ $thread->name }}</a></strong><span class="pull-right"><small>Posted By: {{ $thread->user->username }}</small></span></h4>
@endforeach
<div class="col-md-12">
	{{ $threads->links() }}
</div>
@stop