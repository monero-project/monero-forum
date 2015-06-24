@extends('master')
@section('content')
{{ Breadcrumbs::addCrumb('Home', '/') }}
{{ Breadcrumbs::addCrumb('Not Found') }}
	<div class="row">
		<h1 class="text-center">Oops. We could not find the page <small>(Error: 404)</small></h1>
		<p class="text-center">It looks like whatever you are looking for is not here. We do have a nice working page <a href="/">here</a>, though.</p>
		<p class="text-center"><em>If you feel that this is an error, please contact a member of the staff.</em></p>
	</div>
@stop