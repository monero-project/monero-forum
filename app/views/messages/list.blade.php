@extends('master')

@section('content')
	<div class="row">
		<div class="operations">
			<a href="/messages/create"><button class="btn btn-success pull-right"><span class="glyphicon glyphicon-plus"></span> New Conversation</button></a>
		</div>
	</div>
	@if(count($conversations))
		@foreach($conversations as $conversation)
			<div class="row conversation-row">
				<div class="col-md-8">
					<a href="{{ URL::route('messages.conversation', [$conversation->id]) }}">{{{ $conversation->title  }}}</a> <small class="pull-right">{{ $conversation->created_at->diffForHumans() }}</small>
				</div>
				<div class="col-md-4 text-right">
					<img class="profile-picture-sm" src="/uploads/profile/small_{{ $conversation->user->profile_picture }}"><a href="{{ URL::route('user.show', array($conversation->user->username)) }}">{{ $conversation->user->username }}</a>,
					<img class="profile-picture-sm" src="/uploads/profile/small_{{ $conversation->receiver->profile_picture }}"><a href="{{ URL::route('user.show', array($conversation->receiver->username)) }}">{{ $conversation->receiver->username }}</a>
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