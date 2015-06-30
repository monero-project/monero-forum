@extends('master')
@section('content')
	{{ Form::open(['route' => ['milestones.update', $milestone->id]]) }}
	<div class="form-group">
		<label for="title">Title</label>
		<input type="text" class="form-control" name="title" id="title" value="{{{ $milestone->title }}}">
	</div>
	<div class="form-group">
		<label for="description">Description</label>
		<textarea class="form-control" name="description" id="description">{{{ $milestone->description }}}</textarea>
	</div>
	<div class="form-group">
		<label for="description">Completion Date</label>
		<input type="date" class="form-control" name="completed_at" id="title" value="{{{ $milestone->completed_at }}}">
	</div>
	<div class="form-group">
		<label for="description">Funds Awarded Percentage</label>
		<input type="number" class="form-control" name="funds" id="title" min="0" step="any" value="{{{ $milestone->funds }}}">
	</div>
	<div class="form-group">
		<label for="completed">Completed</label>
		<select name="complete" id="completed" class="form-control">
			@if($milestone->complete)
				<option value="1" selected>Yes</option>
			@else
				<option value="1">Yes</option>
			@endif
			@if(!$milestone->complete)
				<option value="0" selected>No</option>
			@else
				<option value="0">No</option>
			@endif
		</select>
	</div>
	<button class="btn btn-success" type="submit">Save</button> <a href="{{ URL::route('milestones.index', [$milestone->funding->thread_id]) }}"><button class="btn btn-danger" type="button">Back</button></a>
	{{ Form::close() }}
@stop