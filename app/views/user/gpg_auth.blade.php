@extends('master')
@section('content')
{{ Breadcrumbs::addCrumb('Home', '/') }}
{{ Breadcrumbs::addCrumb('Authentication') }}
	<div class="form-style">
		@if (isset($errors) && sizeof($errors) > 0)
			@foreach($errors as $error)
			<h5>{{{ $error }}}</h5>
			@endforeach
		@endif
		{{ Form::open(array('url' => 'gpg-auth')) }}
            <div class="form-group">
            	<label>Please decrypt the password located <a href="/keychain/message/{{{ Auth::user()->key_id }}}" target="_blank">here</a> and enter it below.</label>
            	{{ Form::text('otcp', null, array('class'=>'form-control')) }}
            </div>
	      <button type="submit" class="btn btn-success pull-right">Submit</button>
	    {{ Form::close() }}
	</div>
@stop