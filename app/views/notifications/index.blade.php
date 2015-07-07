@extends('master')

@section('content')

	{{ Breadcrumbs::addCrumb('Home', '/') }}
	{{ Breadcrumbs::addCrumb('Notifications', '/notifications') }}

	<div class="row text-right">
		@if(!Auth::user()->notification_key)
			<a href="{{ route('notifications.generate') }}"><button class="btn btn-success"><i class="fa fa-key"></i> Generate Key</button></a>
		@else
			<a href="{{ route('notifications.rss', [Auth::user()->notification_key->hash]) }}"><button class="btn btn-success"><i class="fa fa-rss"></i> Feed</button></a>
		@endif
	</div>

	@foreach($notifications as $notification)
	@if($notification->object)
	<div class="row">
		<div class="well well-sm well-notification">
			@if(!$notification->is_read())
				<i class="fa fa-circle"></i>
			@else
				<i class="fa fa-circle-o"></i>
			@endif
			@if($notification->notification_type == 'subscription')
			The thread <a href="{{ URL::route('thread.short', [$notification->object->thread_id]) }}">
				{{{ $notification->object->thread->name }}}
			</a>
			has new replies!
			@else
			You have been mentioned in <a href="{{ URL::route('thread.short', [$notification->object->thread_id]) }}">
				{{{ $notification->object->thread->name }}}
			</a>
				by
					<a href="{{ URL::route('user.show', [$notification->object->user->username]) }}">{{{ $notification->object->user->username }}}</a>
			@endif
			<span class="pull-right">{{ $notification->created_at->diffForHumans() }}</span>
		</div>
	</div>
	@endif
	@endforeach
@stop