@extends('master')
@section('content')
	<h1>Managing milestones for {{{ $thread->name }}} <span class="pull-right"><a href="{{ URL::route('milestones.create', [$thread->id]) }}"><button class="btn btn-success">Add a Milestone</button></a></span></h1>
	<ul class="fa-ul">
		@foreach($thread->funding->milestones as $milestone)
			<li>
				@if($milestone->complete)
				<h4><i class="fa-li fa fa-check-square-o"></i>{{{ $milestone->title }}}</h4>
				@else
				<h4><i class="fa-li fa fa-square-o"></i>{{{ $milestone->title }}}</h4>
				@endif
				@if($milestone->description)
				<p>{{{ $milestone->description }}}</p>
				@endif
				<p><a href="/milestones/edit/{{ $milestone->id }}">Edit</a> <a href="/milestones/delete/{{ $milestone->id }}">Delete</a></p>
			</li>
		@endforeach
	</ul>
@stop