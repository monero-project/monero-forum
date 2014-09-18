@extends('master')
@section('content')
	<div class="row admin-panel">
	<div class="panel panel-default">
	  <div class="panel-heading">
	    <h3 class="panel-title"><span class="glyphicon glyphicon-pencil"></span> Editing user {{ $user->username }}</h3>
	  </div>
	  <div class="panel-body">
			  {{ Form::open(array('url' => '/admin/edit')) }}
			  	 <input type="hidden" name="type" value="user">
			  	 <input type="hidden" name="id" value="{{ $user->id }}">
			  	 <div class="form-group">
				    <label>Username</label>
				    <input type="text" class="form-control" name="username" value="{{ $user->username }}">
				 </div>
				 <div class="form-group">
				    <label>Email</label>
				    <input type="text" class="form-control" name="email" value="{{ $user->email }}">
				 </div>
				 @if ($user->in_wot)
				 <div class="form-group">
				    <label>GPG Key ID</label>
				    <input type="text" class="form-control" name="key_id" value="{{ $user->key_id }}">
				 </div>
				 @endif
				 <div class="form-group">
				 	<label>User Role</label>
				 	{{ Form::select('role', Role::lists('name','id'), $user->roles()->first()->id, array('class' => 'form-control')) }}
				 </div>
				 <hr>
				 <p>Only enter a password if you want to change it.</p>
				 <div class="form-group">
				    <label>Password</label>
				    <input type="password" class="form-control" name="password">
				 </div>
				 <div class="form-group">
				    <label>Confirm Password</label>
				    <input type="password" class="form-control" name="password_confirmation">
				 </div>
				 <button type="submit" class="btn btn-md btn-success">Save</button><a href="/admin/delete/user/{{ $user->id }}"><button type="button" class="btn btn-md btn-danger">Delete</button></a>
			  {{ Form::close() }}
	  </div>
	</div>
	</div>
@stop