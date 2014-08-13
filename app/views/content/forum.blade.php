@extends('master')

@section('content')
<h1>{{ $forum->name }}</h1>
@foreach ($threads as $thread)
<h4><strong><a href="/{{ $forum->slug() }}/{{ $forum->id }}/{{ $thread->slug() }}/{{ $thread->id }}">{{ $thread->name }}</a></strong><span class="pull-right"><small>Posted By: {{ $thread->user->username }}</small></span></h4>
@endforeach
<div class="col-lg-12">
	{{ $threads->links() }}
</div>
<div class="col-lg-12">
<a href="/thread/create/{{ $forum->id }}"><button class="btn btn-primary pull-right">Create a Thread</button></a>
</div>
@stop