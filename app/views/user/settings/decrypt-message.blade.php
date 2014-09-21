@extends('master')
@section('content')
{{ Breadcrumbs::addCrumb('Home', '/') }}
{{ Breadcrumbs::addCrumb('User Settings', '/user/settings') }}
{{ Breadcrumbs::addCrumb('GPG Authentication') }}
	<div class="form-style">
		@if (Session::has('errors'))
			@foreach(Session::pull('errors') as $error)
			<h5>{{{ $error }}}</h5>
			@endforeach
		@endif
		{{ Form::open(array('url' => '/user/settings/gpg-decrypt')) }}
            <div class="form-group">
            	<input type="hidden" name="key_id" value="{{ $key_id }}">
            	<input type="hidden" name="fingerprint" value="{{ $fingerprint }}">
            	<label>Please decrypt the password located <a href="/keychain/message/{{{ $key_id }}}" target="_blank">here</a> and enter it below.</label>
            	{{ Form::text('otcp', null, array('class'=>'form-control')) }}
            </div>
	      <button type="submit" class="btn btn-success pull-right">Submit</button>
	    {{ Form::close() }}
	</div>
@stop