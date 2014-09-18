@extends('master')
@section('content')
	@foreach(Role::all() as $role)
		<div class="row">
			<div class="col-lg-12">
				<a href="/admin/edit/role/{{ $role->id }}">{{ $role->name }}</a>
			</div>
		</div>
	@endforeach
@stop