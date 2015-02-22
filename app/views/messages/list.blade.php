@extends('master')

@section('content')
	@if(count($messages))
		@foreach($messages as $message)
			<div class="row">
				<div class="panel panel-default post-panel">
					<div class="panel-heading">
						<img class="profile-picture-sm" src="/uploads/profile/small_{{ $message->sender->profile_picture }}"><a href="{{ URL::route('user.show', array($message->sender->username)) }}">{{ $message->sender->username }}</a> - {{ $message->created_at->diffForHumans() }}
						@if(!$message->is_read)
						<span class="glyphicon glyphicon-envelope dark-green pull-right"></span>
						@endif
					</div>
					<div class="panel-body">
						{{ $message->body }}
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