@extends('master')
@section('content')
{{ Breadcrumbs::addCrumb('Home', '/') }}
{{ Breadcrumbs::addCrumb('User Settings', '/user/settings') }}
{{ Breadcrumbs::addCrumb('Add GPG Key') }}

	<div class="form-style">
		@if (Session::has('errors'))
			@foreach(Session::pull('errors') as $error)
			<h5>{{{ $error }}}</h5>
			@endforeach
		@endif
		{{ Form::open(array('url' => '/user/settings/add-gpg')) }}
            <div class="form-group">
            	<label>Key ID</label>
            	{{ Form::text('key_id', null, array('class'=>'form-control')) }}
            </div>
	      <button type="submit" class="btn btn-success pull-right">Submit</button>
	    {{ Form::close() }}
	</div>
@stop