@extends('master')

@section('content')

	{{ Breadcrumbs::addCrumb('Home', '/') }}
	{{ Breadcrumbs::addCrumb('Admin Panel', '/admin') }}
	{{ Breadcrumbs::addCrumb('Refunds') }}

	<ul>
	@foreach(\Eddieh\Monero\Payment::where('block_height', -1)->get() as $refund)
		<li>{{ $refund->funding->thread->name }} - <strong>Amount: XMR {{ $refund->amount / 1000000000000 }}</strong></li>
	@endforeach
	</ul>

@stop