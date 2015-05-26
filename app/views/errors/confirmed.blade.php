@extends('master')
@section('content')
{{ Breadcrumbs::addCrumb('Home', '/') }}
{{ Breadcrumbs::addCrumb('Account Inactive') }}
	<div class="row">
		<h1 class="text-center">Oops. Account Inactive.</h1>
		<p class="text-center">It looks like you have not activated your account. Be sure to check your email for a link</p>
	</div>
@stop