@extends('master')

@section('content')
	{{ Breadcrumbs::addCrumb('Home', '/') }}
	{{ Breadcrumbs::addCrumb('Messages', route('messages.index')) }}
	{{ Breadcrumbs::addCrumb('New Conversation') }}
	{{ Form::open(['url' => URL::route('messages.send')]) }}
		<div class="form-group">
			<label for="username">Username:</label>
			@if($username)
			<input type="text" class="form-control" id="username" name="username" placeholder="Recipients username" value="{{{ $username }}}">
			@else
			<input type="text" class="form-control" id="username" name="username" placeholder="Recipients username">
			@endif
		</div>
		<div class="form-group">
			<label for="username">Title:</label>
			<input type="text" class="form-control" id="username" name="title" placeholder="The title of your conversation">
		</div>
		<div class="form-group">
			<textarea class="form-control markdown-editor" name="body" id="body" cols="30" rows="10" placeholder="Your message content goes here..."></textarea>
		</div>
		<button type="submit" class="btn btn-success pull-right"><i class="fa fa-send"></i> Send</button>
	{{ Form::close() }}
	<div class="clearfix"></div>
@stop