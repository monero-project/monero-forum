@extends('master')
@section('content')
	<div class="form-style">
@if (isset($errors) && sizeof($errors) > 0)
		<div class="alert alert-danger alert-dismissible" role="alert">
		  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		  <h4>Oops!</h4>
		  @foreach($errors as $error)
		  	{{{ $error }}}<br>
		  @endforeach
		</div>
@endif
		{{ Form::open(array('url' => 'login')) }}
            <div class="form-group">
            	<label>Username</label>
            	{{ Form::text('username', null, array('class'=>'form-control', 'placeholder'=>'')) }}
            </div>     
            <div class="form-group">
            	<label>Password</label>
            	{{ Form::password('password', array('class'=>'form-control', 'placeholder'=>'')) }}
            </div>
	      <button type="submit" class="btn btn-success pull-right">Login</button>
	    {{ Form::close() }}
	</div>
@stop