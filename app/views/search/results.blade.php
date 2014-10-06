@extends('master')
@section('content')
	<div class="row category-block">
	@foreach($results as $result) 
		<div class="panel panel-default thread-block">
		  <div class="panel-heading">
		    <h3 class="panel-title"><span class="glyphicon glyphicon-comment"></span>{{{ $result->name }}} <span class="post-meta"> <a class="poster-name" href="{{ Thread::find($result->id)->permalink() }}" target="_blank">THREAD <span class="glyphicon glyphicon-new-window"></span>
</a></span> <p class="post-meta pull-right"><img class="profile-picture-sm" src="/uploads/profile/small_{{ $result->profile_picture }}"><a href="/user/{{ $result->username }}" class="poster-name" target="_blank">{{{ $result->username }}}</a> <span class="post-date">posted this on {{ $result->created_at }}</span></p></h3>
		  </div>
		  <p class="mobile-post-meta"><a href="/user/{{ $result->username }}" class="poster-name" target="_blank">{{{ $result->username }}}</a> <span class="post-date"> | {{ $result->created_at }}</span></p>
		  <div class="panel-body">
			  <div class="row post-block">
				  {{ Markdown::string(e($result->body)) }}
			  </div>
		  </div>
		</div>
	@endforeach
	</div>
	<div class="row">
		{{ $results->links() }}
	</div>
@stop