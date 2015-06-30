@extends('master')
@section('content')
	{{ Breadcrumbs::addCrumb('Home', '/') }}
	{{ Breadcrumbs::addCrumb('Admin Panel', '/admin') }}
	{{ Breadcrumbs::addCrumb('Manage Milestones', route('milestones.index', [$thread->id])) }}
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
					<p><b>Description</b>: {{{ $milestone->description }}}</p>
				@endif
				@if($milestone->completed_at != '-0001-11-30 00:00:00')
					<p><b>Completion</b>: {{{ $milestone->completed_at->formatLocalized('%A %d %B %Y')  }}}</p>
				@endif
				@if($milestone->funds)
					<p><b>Funds awarded</b>: {{{ $milestone->funds }}}% (~{{ $milestone->funding->symbol().$milestone->fundsConverted() }})</p>
				@endif
				<p><a href="/milestones/edit/{{ $milestone->id }}">Edit</a> <a href="/milestones/delete/{{ $milestone->id }}">Delete</a></p>
			</li>
		@endforeach
	</ul>
@stop