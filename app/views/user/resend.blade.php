@extends('master')
@section('content')
	<div class="form-style">
	<p>Did your activation email get lost? No problem, just enter your email below and we will send you another one!</p>
	{{ Form::open(array('url' => '/user/resend-activation')) }}
            <div class="form-group">
            	<label>Email</label>
            	{{ Form::email('email', null, array('class'=>'form-control reg-username', 'placeholder'=>'')) }}
            </div>
	        <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-send white-glyph"></i> Send!</button>
	{{ Form::close() }}
	</div>
@stop