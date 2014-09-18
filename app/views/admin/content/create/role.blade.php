@extends('master')
@section('content')
{{ Breadcrumbs::addCrumb('Home', '/') }}
{{ Breadcrumbs::addCrumb('Admin Panel', '/admin') }}
{{ Breadcrumbs::addCrumb('Create a Role') }}
	<div class="row admin-panel">
	<div class="panel panel-default">
	  <div class="panel-heading">
	    <h3 class="panel-title"><span class="glyphicon glyphicon-plus"></span> Create a Role</h3>
	  </div>
	  <div class="panel-body">
			  {{ Form::open(array('url' => '/admin/create')) }}
			  	 <input type="hidden" name="type" value="role">
			  	 <div class="form-group">
				    <label>Name</label>
				    <input type="text" class="form-control" name="name" placeholder="Moderator">
				 </div>
				 <button type="submit" class="btn btn-md btn-success">Create</button>
			  {{ Form::close() }}
	  </div>
	</div>
	</div>
@stop