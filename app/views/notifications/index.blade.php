@extends('master')

@section('content')

	{{ Breadcrumbs::addCrumb('Home', '/') }}
	{{ Breadcrumbs::addCrumb('Notifications', '/notifications') }}

	@foreach($notifications as $notification)
	<div class="row">
		<div class="well well-sm">
			@if(!$notification->is_read())
			<span class="label label-success">New!</span>
			@endif
			The thread <a href="{{ URL::route('thread.short', [$notification->subscription->thread_id]) }}">
				{{{ $notification->subscription->thread->name }}}
			</a>
			has new replies!
			<span class="pull-right">{{ $notification->created_at->diffForHumans() }}</span>
		</div>
	</div>
	@endforeach
@stop