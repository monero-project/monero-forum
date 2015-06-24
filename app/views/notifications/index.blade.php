@extends('master')

@section('content')

	{{ Breadcrumbs::addCrumb('Home', '/') }}
	{{ Breadcrumbs::addCrumb('Notifications', '/notifications') }}

	@foreach($notifications as $notification)
	@if($notification->object)
	<div class="row">
		<div class="well well-sm">
			@if(!$notification->is_read())
			<span class="label label-success">New!</span>
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