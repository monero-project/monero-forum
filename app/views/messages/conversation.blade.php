@extends('master')

@section('content')

	{{ Breadcrumbs::addCrumb('Home', '/') }}
	{{ Breadcrumbs::addCrumb('Messages', '/messages') }}
	{{ Breadcrumbs::addCrumb(e($conversation->title), URL::route('messages.conversation', [$conversation->id])) }}

	<div class="media markdown-toolbar">
		<div class="pull-left">
			<img class="media-object reply-box-avatar" src="/uploads/profile/small_{{ Auth::user()->profile_picture }}" alt="{{ Auth::user()->username }} Profile Picture">
		</div>
		<div class="media-body">
			{{ Form::open(['url' => URL::route('messages.reply')]) }}
				<input type="hidden" name="conversation" value="{{ $conversation->id }}"/>
				<div class="form-group">
					<textarea class="form-control markdown-editor" name="body" id="body" rows="2" placeholder="Your reply text goes here..."></textarea>
				</div>
				<div class="pull-left">
					<p>For post formatting please use Kramdown, <a href="http://kramdown.gettalong.org/syntax.html">click here</a> for a syntax guide.</p>
				</div>
				<div class="markdown-form-buttons">
					<button class="btn btn-success pull-right"><span class="glyphicon glyphicon-send"></span> Reply</button>
				</div>
			<div class="clearfix"></div>
			{{ Form::close() }}
		</div>
	</div>

	<div class="row messages">
	@if(count($messages))
		@foreach($messages as $message)
			<div class="panel panel-default post-panel">
				<div class="panel-heading">
					<img class="profile-picture-sm" src="/uploads/profile/small_{{ $message->user->profile_picture }}"><a href="{{ URL::route('user.show', [$message->user->username]) }}" target="_blank">{{ $message->user->username }}</a> <span class="mobile-hide-text">sent this on</span> <span class="date">{{ $message->created_at }}</span>
				</div>
				<div class="panel-body content-block-82" style="display: block;">
					<div class="post-content-82">
						{{ $message->body }}
					</div>
				</div>
			</div>
		@endforeach

	<div class="post-links">
		{{ $messages->links() }}
	</div>
	@else
		<div class="well text-center">
			You don't have any messages!
		</div>
	@endif
	</div>
@stop