@extends('master')

@section('content')
	@if(count($conversations))
		@foreach($conversations as $conversation)
			<div class="row">
				<div class="panel panel-default post-panel">
					<div class="panel-heading">
						<img class="profile-picture-sm" src="/uploads/profile/small_{{ $conversation->user->profile_picture }}"><a href="{{ URL::route('user.show', array($conversation->user->username)) }}">{{ $conversation->user->username }}</a> - {{ $conversation->created_at->diffForHumans() }}
						@if(!$conversation->is_read)
						<span class="glyphicon glyphicon-envelope dark-green pull-right"></span>
						@endif
					</div>
					<div class="panel-body">
						test
					</div>
				</div>
			</div>
		@endforeach
	@else
		<div class="row">
			<div class="well">
				You have no messages.
			</div>
		</div>
	@endif
@stop