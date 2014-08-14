@extends('master')
@section('content')
	<div class="col-lg-12">
		<h1>Create a Thread</h1>
		{{ Form::open(array('url' => '/thread/create')) }}
		 <input type="hidden" value="{{ $forum->id }}" name="forum_id">
		  <div class="form-group">
		    <input type="text" class="form-control" name="name" placeholder="Your descriptive thread title goes here.">
		  </div>
		  <div class="form-group">
		    <textarea name="body" class="form-control" rows="10" placeholder="Anything you want to say in your thread should be here."></textarea>
		  </div>
		  <button type="submit" class="btn btn-success">Create Thread</button>
		  <a href="{{ $forum->permalink() }}"><button type="button" class="btn btn-danger">Back</button></a>
		{{ Form::close() }}
	</div>
@stop