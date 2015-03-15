@extends('master')

@section('content')

	<div class="row">
	{{ Form::open(['url' => URL::route('messages.reply')]) }}
		<input type="hidden" name="conversation" value="{{ $conversation->id }}"/>
		<div class="form-group">
			<textarea class="form-control bs-md" name="body" id="body" cols="30" rows="10" placeholder="Your reply text goes here..."></textarea>
		</div>
		<button class="btn btn-success pull-right"><span class="glyphicon glyphicon-send"></span> Reply</button>
	<div class="clearfix"></div>
	{{ Form::close() }}
	</div>

	<div class="row messages">
	@if(count($messages))
		@foreach($messages as $message)
			<div class="panel panel-default post-panel">
				<div class="panel-heading">
					<img class="profile-picture-sm" src="/uploads/profile/small_{{ $message->user->profile_picture }}"><a href="{{ URL::route('user.show', [$message->user->username]) }}" target="_blank">{{ $message->user->username }}</a> <span class="mobile-hide-text">sent this on</span> <span class="date">{{ $message->created_at }}</span>
				</div>
				<div class="panel-body content-block-82 hidden-post-content" style="display: block;">
					<div class="post-content-82">
						{{ Markdown::string(e($message->body)) }}
					</div>
				</div>
			</div>
		@endforeach
	@else
		<div class="well text-center">
			You don't have any messages!
		</div>
	@endif
	</div>
@stop