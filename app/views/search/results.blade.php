@extends('master')
@section('content')
	@if(count($results))
	<div class="row category-block">
	@foreach($results as $result) 
		<div class="panel panel-default thread-block">
		  <div class="panel-heading">
		    <h3 class="panel-title"><span class="glyphicon glyphicon-comment"></span><a href="{{ URL::route('thread.short', array($result->id)) }}">{{{ $result->name }}}</a> <span class="post-meta"><span class="glyphicon glyphicon-new-window"></span>
</a></span> <p class="post-meta pull-right"><img class="profile-picture-sm" src="/uploads/profile/small_{{ $result->profile_picture }}"><a href="/user/{{ $result->username }}" class="poster-name" target="_blank">{{{ $result->username }}}</a> <span class="post-date">posted this on {{ $result->created_at }}</span></p></h3>
		  </div>
		  <p class="mobile-post-meta"><a href="/user/{{ $result->username }}" class="poster-name" target="_blank">{{{ $result->username }}}</a> <span class="post-date"> | {{ $result->created_at }}</span></p>
		  <div class="panel-body">
			  <div class="row post-block">
				  {{ $result->body }}
			  </div>
		  </div>
		</div>
	@endforeach
	</div>
	<div class="row">
		{{ $results->links() }}
	</div>
	@else
		<div class="row">
			<div class="well">
				There are no results!
			</div>
		</div>
	@endif
@stop