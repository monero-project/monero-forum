@extends('master')

@section('content')

	{{ Breadcrumbs::addCrumb('Home', '/') }}
	{{ Breadcrumbs::addCrumb('Admin Panel', '/admin') }}
	{{ Breadcrumbs::addCrumb('Payouts') }}

	<ul>
	@foreach($payouts as $payout)
		<li>{{ $payout->amount }} XMR - {{ $payout->created_at->formatLocalized('%A %d %B %Y') }}</li>
	@endforeach
	</ul>
@stop