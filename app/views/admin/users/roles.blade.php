@extends('master')
@section('content')
{{ Breadcrumbs::addCrumb('Home', '/') }}
{{ Breadcrumbs::addCrumb('Admin Panel', '/admin') }}
{{ Breadcrumbs::addCrumb('Roles') }}
	@foreach(Role::all() as $role)
		<div class="row">
			<div class="col-lg-12">
				<a href="/admin/edit/role/{{ $role->id }}">{{ $role->name }}</a>
			</div>
		</div>
	@endforeach
@stop