@extends('master')
@section('content')
{{ Breadcrumbs::addCrumb('Home', '/') }}
{{ Breadcrumbs::addCrumb('Admin Panel', '/admin') }}
{{ Breadcrumbs::addCrumb('Manage Roles', '/admin/manage/roles') }}
{{ Breadcrumbs::addCrumb($role->name) }}
	<div class="row admin-panel">
	<div class="panel panel-default">
	  <div class="panel-heading">
	    <h3 class="panel-title"><span class="glyphicon glyphicon-star"></span> Editing role {{ $role->name }}</h3>
	  </div>
	  <div class="panel-body">
			  {{ Form::open(array('url' => '/admin/edit')) }}
			  	 <input type="hidden" name="type" value="role">
			  	 <input type="hidden" name="id" value="{{ $role->id }}">
			  	 <div class="form-group">
				    <label>Name</label>
				    <input type="text" class="form-control" name="name" value="{{ $role->name }}">
				 </div>
				 <hr>
				 <button type="submit" class="btn btn-md btn-success">Save</button><a href="/admin/delete/role/{{ $role->id }}"><button type="button" class="btn btn-md btn-danger">Delete</button></a>
			  {{ Form::close() }}
	  </div>
	</div>
	</div>
@stop