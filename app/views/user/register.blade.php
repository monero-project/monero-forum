@extends('master')
@section('content')
{{ Breadcrumbs::addCrumb('Home', '/') }}
{{ Breadcrumbs::addCrumb('Register') }}
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
		{{ Form::open(array('url' => 'register')) }}
            <div class="form-group">
            	<label>Username</label>
            	{{ Form::text('username', null, array('class'=>'form-control reg-username', 'placeholder'=>'')) }}
            </div>
            <div class="form-group username-alert" style="display: none;">
            	<div class="alert alert-warning alert-dismissible" role="alert">
				  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				  It looks like this username is already taken in the Web of Trust. In order to use this name, you will have to confirm your ownership of the name with the key belonging to this user.
				</div>
            </div>          
            <div class="form-group">
            	<label>Email</label>
            	{{ Form::email('email', null, array('class'=>'form-control', 'placeholder'=>'')) }}
            </div>      
            <div class="form-group">
            	<label>Password</label>
            	{{ Form::password('password', array('class'=>'form-control', 'placeholder'=>'')) }}
            </div>
            <div class="form-group">
            	<label>Confirm Password</label>
            	{{ Form::password('password_confirmation', array('class'=>'form-control', 'placeholder'=>'')) }}
            </div>
            <div class="form-group reg-key">
            	<label>Key ID</label>
            	{{ Form::text('key', null, array('class'=>'form-control')) }}
            	<p class="help-block">Only fill this out if you are registering for the Web of Trust!</p>
            </div>
            <div class="checkbox wot_register">
			    <label>
			      <input type="checkbox" name="wot_register" class="wot_register_check"> <small>(Optional)</small> Register in the Web of Trust? Requires GPG / PGP 
			    </label>
			</div>
	        <button type="submit" class="btn btn-success">Register</button>
	      {{ Form::close() }}
	</div>
@stop

@section('javascript')
{{ HTML::script('js/register.js') }}
@stop