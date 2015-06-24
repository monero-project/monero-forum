@extends('master')
@section('content')
{{ Breadcrumbs::addCrumb('Home', '/') }}
{{ Breadcrumbs::addCrumb('Error') }}
	<div class="row">
		<h1 class="text-center">Oops. Looks like you broke the forum! <small>(Error: 905)</small></h1>
		<p class="text-center">Well, this is embarrassing. We have taken note of this error and will fix it ASAP.</p>
	</div>
@stop