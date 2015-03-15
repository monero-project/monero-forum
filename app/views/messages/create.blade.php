@extends('master')

@section('content')
	<div class="row">
	{{ Form::open(['url' => URL::route('messages.send')]) }}
		<div class="form-group">
			<label for="username">Username:</label>
			<input type="text" class="form-control" id="username" name="username" placeholder="Recipients username">
		</div>
		<div class="form-group">
			<label for="username">Title:</label>
			<input type="text" class="form-control" id="username" name="title" placeholder="The title of your conversation">
		</div>
		<div class="form-group">
			<textarea class="form-control" name="body" id="body" cols="30" rows="10" placeholder="Your message content goes here..."></textarea>
		</div>
		<button type="submit" class="btn btn-success pull-right"><span class="glyphicon glyphicon-send"></span> Send</button>
	{{ Form::close() }}
	<div class="clearfix"></div>
	</div>
@stop