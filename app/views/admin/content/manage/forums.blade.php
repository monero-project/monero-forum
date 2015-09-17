@extends('master')
@section('content')
{{ Breadcrumbs::addCrumb('Home', '/') }}
{{ Breadcrumbs::addCrumb('Admin Panel', '/admin') }}
{{ Breadcrumbs::addCrumb('Manage Forums') }}
	<div class="row admin-panel">
	<div class="panel panel-default">
	  <div class="panel-heading">
	    <h3 class="panel-title"><i class="fa fa-list"></i> All Forums</h3>
	  </div>
	  <div class="panel-body">
		  <ul class="nav nav-pills nav-stacked">
			  @foreach(Forum::all() as $forum)
			  <li><a href="/admin/edit/forum/{{ $forum->id }}">{{ $forum->name }} <span class="badge pull-right">{{ $forum->id }}</span></a></li>
			  @endforeach
		  </ul>
	  </div>
	</div>
	</div>
@stop