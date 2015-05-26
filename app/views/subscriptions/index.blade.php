@extends('master')

@section('content')
	<ol>
	@foreach($subscriptions as $subscription)
		<li class="sub-item">
			<a href="{{{ URL::route('thread.short', [$subscription->thread_id]) }}}">{{{ $subscription->thread->name }}}</a> <a href="{{ URL::route('subscriptions.unsubscribe', [$subscription->thread_id]) }}"><button class="btn btn-danger btn-sm pull-right">Unsubscribe</button></a>
		</li>
	@endforeach
	</ol>
@stop