@extends('master')
@section('content')
	<div class="row admin-panel">
	<div class="panel panel-default col-md-4">
	  <div class="panel-heading">
	    <h3 class="panel-title"><i class="fa fa-bar-chart"></i> Statistics</h3>
	  </div>
	  <div class="panel-body">
		  <ul class="nav nav-pills nav-stacked">
			  <li>Total Threads <span class="badge pull-right">{{ Thread::count() }}</span></li>
			  <li>Total Posts <span class="badge pull-right">{{ Post::count() }}</span></li>
			  <li>Total Users <span class="badge pull-right">{{ User::count() }}</span></li>
			  <li>Total Ratings <span class="badge pull-right">{{ Rating::count() }}</span></li>
		  </ul>
	  </div>
	</div>
	<div class="panel panel-default col-md-8">
	  <div class="panel-heading">
	    <h3 class="panel-title"><i class="fa fa-dashboard"></i> Admin Actions</h3>
	  </div>
	  <div class="panel-body">
		  <div class="row">
		  	<div class="col-md-6">
		  		<ul class="nav nav-pills nav-stacked">
		  			<li><a href="/admin/create/category">Create a Category</a></li>
		  			<li><a href="/admin/create/forum">Create a Forum</a></li>
		  			<li><a href="/admin/cache/flush">Clear Cache</a></li>
		  			<li><a href="/admin/create/role">Create Role</a></li>
		  		</ul>
		  	</div>
		  	<div class="col-md-6">
		  		<ul class="nav nav-pills nav-stacked">
		  			<li><a href="/admin/manage/category">Manage Categories</a></li>
		  			<li><a href="/admin/manage/forum">Manage Forums</a></li>
		  			<li><a href="/admin/manage/user">Manage Users</a></li>
		  			<li><a href="/admin/manage/roles">Manage Roles</a></li>
				    <li><a href="/admin/manage/funds">Manage Funds</a></li>
				    <li><a href="/admin/manage/milestones">Manage Milestones</a></li>
		  		</ul>
		  	</div>
		  </div>
	  </div>
	</div>
	</div>
	<div class="row admin-panel">
	<div class="panel panel-default col-md-12">
	  <div class="panel-heading">
	    <h3 class="panel-title"><i class="fa fa-flag"></i> Flags</h3>
	  </div>
	  <div class="panel-body">
		  @foreach(Flag::where('status', '!=', 2)->orderBy('created_at', 'DESC')->paginate(10) as $report)
		  <div class="row report-row">
		  <div class="col-md-10">
		  	<div class="row">
			  	<div class="col-md-8">
			  		<quote>
			  		{{ $report->post->body }}
			  		</quote>
			  	</div>
			  	<div class="col-md-4">
			  		Posted by: {{{ $report->post->user->username }}}
			  	</div>
		  	</div>
		  	<div class="row">
			  	<div class="col-md-8">
			  		{{{ $report->comment }}}
			  	</div>
			  	<div class="col-md-4">
			  		Reported by: {{ $report->user->username }}
			  	</div>
		  	</div>
		  </div>
		  <div class="col-md-2">
			<div class="btn-group">
			  <button type="button" class="btn btn-sm 
			  @if($report->status == 0)
			  btn-success
			  @elseif($report->status == 1)
			  btn-danger
			  @endif 
			  dropdown-toggle" data-toggle="dropdown">
			    Action <span class="caret"></span>
			  </button>
			  <ul class="dropdown-menu" role="menu">
			  	<li><a href="{{ $report->link }}">Visit</a></li>
			  	<li class="divider"></li>
			    <li><a href="/admin/delete/post/{{ $report->post->id }}">Delete</a></li>
			    <li class="divider"></li>
			    <li><a href="/admin/flag/status/{{$report->id}}/1">Under Review</a></li>
			    <li><a href="/admin/flag/status/{{$report->id}}/0">New Flag</a></li>
			    <li><a href="/admin/flag/status/{{$report->id}}/2">Completed</a></li>
			  </ul>
			</div>
		  </div>
		  </div>
		  @endforeach
	  </div>
	</div>
	</div>
	<div class="row admin-panel">
		<div class="panel panel-default col-md-12">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-filter"></i> Moderation Queue</h3>
			</div>
			<div class="panel-body">
				@foreach($queued as $queued_item)
					<div class="media queued-item">
						<div class="media-left">
							<a href="{{ route('user.show', $queued_item->user->username) }}">
								<img class="profile-picture-sm queued-picture" src="/uploads/profile/small_{{ $queued_item->user->profile_picture }}">
							</a>
						</div>
						<div class="media-body">
							<h4 class="media-heading">Author: <a href="{{ route('user.show', $queued_item->user->username) }}">{{{ $queued_item->user->username }}}</a></h4>
							<h4 class="media-heading">Thread: <a href="/t/{{ $queued_item->thread_id }}">{{{ $queued_item->thread->name }}}</a></h4>
							{{ $queued_item->body }}
							@if($queued_item->akismet)
								<p class="help-block">This post has been marked as spam by <strong>Akismet</strong>.</p>
							@else
								<p class="help-block">This post has been reported as spam by <strong>users</strong> or <strong>bamwar filter</strong>.</p>
							@endif
							<div class="controls">
								<a href="{{ route('akismet.approve', $queued_item->id) }}"><button class="btn btn-sm btn-success"><i class="fa fa-check"></i> Approve</button></a>
								<a href="{{ route('akismet.delete', $queued_item->id) }}"><button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Delete</button></a>
								@if(!$queued_item->akismet)
								<a href="{{ route('akismet.spam', $queued_item->id) }}"><button class="btn btn-sm btn-warning"><i class="fa fa-trash"></i> SPAM</button></a>
								@else
								<a href="{{ route('akismet.ham', $queued_item->id) }}"><button class="btn btn-sm btn-info"><i class="fa fa-check"></i> HAM</button></a>
								@endif
								<a href="{{ route('akismet.nuke', $queued_item->id) }}"><button class="btn btn-sm btn-danger"><i class="fa fa-bomb"></i> Nuke</button></a>
							</div>
						</div>
					</div>
				@endforeach
			</div>
		</div>
	</div>
@stop