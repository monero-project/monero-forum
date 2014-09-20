@extends('master')
@section('content')
{{ Breadcrumbs::addCrumb('Home', '/') }}
{{ Breadcrumbs::addCrumb('Admin Panel', '/admin') }}
{{ Breadcrumbs::addCrumb('Create a Forum') }}
	<div class="row admin-panel">
	<div class="panel panel-default">
	  <div class="panel-heading">
	    <h3 class="panel-title"><span class="glyphicon glyphicon-plus"></span> Create a Forum</h3>
	  </div>
	  <div class="panel-body">
		  <ul class="nav nav-pills nav-stacked">
			  {{ Form::open(array('url' => '/admin/create')) }}
			  	 <input type="hidden" name="type" value="forum">
			  	 <div class="form-group">
			  	 	{{ Form::select('category_id', Category::lists('name', 'id'), null, array('class' => 'form-control')) }}
			  	 </div>
			  	 <div class="form-group">
				    <label>Name</label>
				    <input type="text" class="form-control" name="name" placeholder="News & Announcements">
				 </div>
				 <div class="form-group">
				    <label>Position</label>
				    <input type="text" class="form-control" name="position" placeholder="1">
				 </div>
				 <div class="form-group">
				    <label>Description</label>
				    <textarea class="form-control" rows="2" name="description" placeholder="All of the Moner News and Announcements can be found here."></textarea>
				 </div>
				 <div class="form-group">
				 	<label>Visible to</label>
				 	{{ Form::select('visibility[]',Role::lists('name','id'), NULL, array('multiple', 'class' => 'form-control')) }}
				 </div>
				 <div class="form-group">
				 	<label>Forum Lock</label>
				 	<br>
				 	<div class="radio">
					 	<label>
						  <input type="radio" name="lock" value="0" checked> No Lock
						</label>
				 	</div>
				 	<div class="radio">
						<label>
						  <input type="radio" name="lock" value="1"> Soft Lock <small>no threads by non-admins / moderators, posts allowed</small>
						</label>
				 	</div>
				 	<div class="radio">
						<label>
						  <input type="radio" name="lock" value="2"> Hard Lock <small>no threads or posts by non-admins / moderators</small>
						</label>
				 	</div>
				 </div>
				 <button type="submit" class="btn btn-md btn-success">Create</button>
			  {{ Form::close() }}
		  </ul>
	  </div>
	</div>
	</div>
@stop