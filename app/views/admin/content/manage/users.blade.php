@extends('master')
@section('content')
{{ Breadcrumbs::addCrumb('Home', '/') }}
{{ Breadcrumbs::addCrumb('Admin Panel', '/admin') }}
{{ Breadcrumbs::addCrumb('Manage Users') }}
	<div class="row admin-panel">
	<div class="panel panel-default">
	  <div class="panel-heading">
	    <h3 class="panel-title"><span class="glyphicon glyphicon-user"></span> All Users</h3>
	  </div>
	  <div class="panel-body">
			  <table class="table">
			  <thead>
			  	<tr>
			  		<th>ID</th>
			  		<th>Username</th>
			  		<th>Email</th>
			  		<th>Registered At</th>
			  		<th>Last IP</th>
			  		<th>Last User Agent</th>
			  	</tr>
			  </thead>
			  <tbody>
			  @foreach(User::all() as $user)
			  	<tr>
			  		<td>{{ $user->id }}</td>
			  		<td><a href="/admin/edit/user/{{ $user->id }}">{{ $user->username }}</a></td>
			  		<td>{{ $user->email }}</td>
			  		<td>{{ $user->created_at }}</td>
			  		<td>{{ $user->access()->orderBy('created_at', 'DESC')->first()['ip'] }}</td>
			  		<td>{{ $user->access()->orderBy('created_at', 'DESC')->first()['user_agent'] }}</td>
			  	</tr>
			  @endforeach
			  </tbody>
			  </table>
	  </div>
	</div>
	</div>
@stop

@section('css')
	<link href="/css/jquery.dataTables.min.css" rel="stylesheet">
@stop

@section('javascript')
	<script src="//static.monero.cc/js/jquery.dataTables.min.js"></script>
	<script>
		$(document).ready(function(){
		    $('table').dataTable();
		});
	</script>
@stop