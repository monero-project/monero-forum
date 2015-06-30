@extends('master')
@section('content')
	<div class="row admin-panel">
	<div class="panel panel-default col-md-4">
	  <div class="panel-heading">
	    <h3 class="panel-title"><span class="glyphicon glyphicon-stats"></span> Statistics</h3>
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
	    <h3 class="panel-title"><span class="glyphicon glyphicon-dashboard"></span> Admin Actions</h3>
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
	    <h3 class="panel-title"><span class="glyphicon glyphicon-flag"></span> Flagged Posts</h3>
	  </div>
	  <div class="panel-body">
		  @foreach(Flag::where('status', '!=', 2)->orderBy('created_at', 'DESC')->paginate(10) as $report)
		  <div class="row report-row">
		  <div class="col-md-10">
		  	<div class="row">
			  	<div class="col-md-8">
			  		<quote>
			  		{{ Markdown::string(e($report->post->body)) }}
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
			  	<li><a href="{{ $report->link }}">Visit Post</a></li>
			  	<li class="divider"></li>
			    <li><a href="/admin/delete/post/{{ $report->post->id }}">Delete Post</a></li>
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
	</div>
@stop