@extends('master')
@section('content')
{{ Breadcrumbs::addCrumb('Home', '/') }}
{{ Breadcrumbs::addCrumb('Password Recovery', '/forgot-password') }}
{{ Breadcrumbs::addCrumb('Reset Password', '/user/'.$user->id.'/'.$recovery_token) }}
	<div class="form-style">
		{{ Form::open(array('url' => '/user/recover')) }}
		{{ Form::hidden('user_id', $user->id, array('class'=>'form-control', 'placeholder'=>'')) }}
		{{ Form::hidden('recovery_token', $recovery_token, array('class'=>'form-control', 'placeholder'=>'')) }}
            <div class="form-group">
            	<label>Password</label>
            	{{ Form::password('password', array('class'=>'form-control', 'placeholder'=>'')) }}
            </div>
            <div class="form-group">
            	<label>Confirm Password</label>
            	{{ Form::password('password_confirmation', array('class'=>'form-control', 'placeholder'=>'')) }}
            </div>
			@if ($user->in_wot)
        	<div class="form-group">
            	<label>Please decrypt the passphrase located <a href="/keychain/message/{{{ $user->key_id }}}" target="_blank">here</a> and enter it below.</label>
            	{{ Form::text('otcp', null, array('class'=>'form-control')) }}
            </div>
			@endif
	      <button type="submit" class="btn btn-success pull-right">Save</button>
	    {{ Form::close() }}
	</div>
@stop