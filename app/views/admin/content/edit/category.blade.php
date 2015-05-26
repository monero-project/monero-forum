@extends('master')
@section('content')
{{ Breadcrumbs::addCrumb('Home', '/') }}
{{ Breadcrumbs::addCrumb('Admin Panel', '/admin') }}
{{ Breadcrumbs::addCrumb('Manage Categories', '/admin/manage/category') }}
{{ Breadcrumbs::addCrumb($category->name) }}
	<div class="row admin-panel">
	<div class="panel panel-default">
	  <div class="panel-heading">
	    <h3 class="panel-title"><span class="glyphicon glyphicon-pencil"></span> Editing category {{ $category->name }}</h3>
	  </div>
	  <div class="panel-body">
			  {{ Form::open(array('url' => '/admin/edit')) }}
			  	 <input type="hidden" name="type" value="category">
			  	 <input type="hidden" name="id" value="{{ $category->id }}">
			  	 <div class="form-group">
				    <label>Name</label>
				    <input type="text" class="form-control" name="name" value="{{ $category->name }}">
				 </div>
				 <div class="form-group">
				    <label>Position</label>
				    <input type="text" class="form-control" name="position" value="{{ $category->position }}">
				 </div>
				 <div class="form-group">
				 	<label>Visible to</label>
				 	{{ Form::select('visibility[]', Role::lists('name','id'), $visible_to, array('multiple', 'class' => 'form-control',)) }}
				 </div>
				 <button type="submit" class="btn btn-md btn-success">Save</button><a href="/admin/delete/category/{{ $category->id }}"><button type="button" class="btn btn-md btn-danger">Delete</button></a>
			  {{ Form::close() }}
	  </div>
	</div>
	</div>
@stop