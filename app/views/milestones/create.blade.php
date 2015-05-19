@extends('master')
@section('content')
	{{ Form::open(['route' => 'milestones.store']) }}
	<input type="hidden" value="{{ $thread->funding->id }}" name="funding_id"/>
	<div class="form-group">
		<label for="title">Title</label>
		<input type="text" class="form-control" name="title" id="title">
	</div>
	<div class="form-group">
		<label for="description">Description</label>
		<textarea class="form-control" name="description" id="description"></textarea>
	</div>
	<div class="form-group">
		<label for="completed">Completed</label>
		<select name="complete" id="completed" class="form-control">
				<option value="1">Yes</option>
				<option value="0" selected>No</option>
		</select>
	</div>
	<button class="btn btn-success" type="submit">Save</button> <a href="{{ URL::route('milestones.index', [$thread->id]) }}"><button class="btn btn-danger" type="button">Back</button></a>
	{{ Form::close() }}
@stop