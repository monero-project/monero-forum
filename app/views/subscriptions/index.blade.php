@extends('master')
{{ Breadcrumbs::addCrumb('Home', '/') }}
{{ Breadcrumbs::addCrumb('Settings', '/user/settings') }}
{{ Breadcrumbs::addCrumb('Subscriptions') }}
@section('content')
	@foreach($subscriptions as $subscription)
		<div class="row">
			<div class="well well-sm well-subscription">
				<i class="fa fa-circle-o"></i> <a href="{{{ URL::route('thread.short', [$subscription->thread_id]) }}}">{{{ $subscription->thread->name }}}</a> <a class="pull-right" href="{{ URL::route('subscriptions.unsubscribe', [$subscription->thread_id]) }}"><i class="fa fa-times btn-unsub"></i></a>
				<div class="clearfix"></div>
			</div>
		</div>
	@endforeach
@stop