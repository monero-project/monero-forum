@extends('master')
@section('content')
{{ Breadcrumbs::addCrumb('Home', '/') }}
{{ Breadcrumbs::addCrumb('Password Recovery') }}
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
		{{ Form::open(array('url' => '/user/forgot-password')) }}
            <div class="form-group">
            	<label>Email</label>
            	{{ Form::email('email', null, array('class'=>'form-control', 'placeholder'=>'')) }}
            </div>
	      <button type="submit" class="btn btn-success pull-right">Recover</button>
	    {{ Form::close() }}
	    <p class="helpblock">Had a moment of clarity? <a href="/login">Login.</a></p>
	</div>
@stop