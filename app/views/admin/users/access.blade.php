@extends('master')
@section('content')
{{ Breadcrumbs::addCrumb('Home', '/') }}
{{ Breadcrumbs::addCrumb('Admin Panel', '/admin') }}
{{ Breadcrumbs::addCrumb('Access Log') }}
	<div class="row admin-panel">
	<div class="panel panel-default">
	  <div class="panel-heading">
	    <h3 class="panel-title"><span class="glyphicon glyphicon-align-justify"></span> Access Log for {{ $user->username }}</h3>
	  </div>
	  <div class="panel-body">
		  <div class="table-responsive">
			  <table class="table">
				  <thead>
				  	<tr>
				  		<th>#</th>
				  		<th>Access Date</th>
				  		<th>IP</th>
				  		<th>User Agent</th>
				  	</tr>
				  </thead>
				  <tbody>
				  @foreach ($access_log as $key => $item)
				  	<tr>
				  		<td>{{ $key }}</td>
				  		<td>{{ $item->created_at }}</td>
				  		<td>{{ $item->ip }}</td>
				  		<td>{{ $item->user_agent }}</td>
				  	</tr>
				  @endforeach
				  </tbody>
			  </table>
		  </div>
			  {{ $access_log->links() }}
	  </div>
	</div>
	</div>
@stop