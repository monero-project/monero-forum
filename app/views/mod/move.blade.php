@extends('master')
@section('content')
{{ Breadcrumbs::addCrumb('Home', '/') }}
{{ Breadcrumbs::addCrumb('Move Thread') }}
	<div class="row admin-panel">
	<div class="panel panel-default">
	  <div class="panel-heading">
	    <h3 class="panel-title"><span class="glyphicon glyphicon-share-alt"></span> Moving {{ $thread->name }}</h3>
	  </div>
	  <div class="panel-body">
			  {{ Form::open(array('url' => '/mod/move/thread')) }}
			  	 <input type="hidden" name="thread_id" value="{{ $thread->id }}">
			  	 <div class="form-group">
			  	 	{{ Form::select('move_to', Forum::lists('name', 'id'), $thread->forum_id, array('class' => 'form-control')) }}
			  	 </div>
				 <button type="submit" class="btn btn-md btn-success">Move</button>
			  {{ Form::close() }}
	  </div>
	</div>
	</div>
@stop