@extends('master')
@section('content')
	<div class="row admin-panel">
	<div class="panel panel-default">
	  <div class="panel-heading">
	    <h3 class="panel-title"><span class="glyphicon glyphicon-plus"></span> Create a Category</h3>
	  </div>
	  <div class="panel-body">
			  {{ Form::open(array('url' => '/admin/create')) }}
			  	 <input type="hidden" name="type" value="category">
			  	 <div class="form-group">
				    <label>Name</label>
				    <input type="text" class="form-control" name="name" placeholder="News & Announcements">
				 </div>
				 <div class="form-group">
				    <label>Position</label>
				    <input type="text" class="form-control" name="position" placeholder="1">
				 </div>
				 <div class="form-group">
				 	<label>Visible to</label>
				 	{{ Form::select('visibility[]',Role::lists('name','id'), NULL, array('multiple', 'class' => 'form-control')) }}
				 </div>
				 <button type="submit" class="btn btn-md btn-success">Create</button>
			  {{ Form::close() }}
	  </div>
	</div>
	</div>
@stop