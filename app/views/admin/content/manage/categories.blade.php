@extends('master')
@section('content')
{{ Breadcrumbs::addCrumb('Home', '/') }}
{{ Breadcrumbs::addCrumb('Admin Panel', '/admin') }}
{{ Breadcrumbs::addCrumb('Manage Categories') }}
	<div class="row admin-panel">
	<div class="panel panel-default">
	  <div class="panel-heading">
	    <h3 class="panel-title"><span class="glyphicon glyphicon-list"></span> All Categories</h3>
	  </div>
	  <div class="panel-body">
		  <ul class="nav nav-pills nav-stacked">
			  @foreach(Category::all() as $category)
			  <li><a href="/admin/edit/category/{{ $category->id }}">{{ $category->name }} <span class="badge pull-right">{{ $category->id }}</span></a></li>
			  @endforeach
		  </ul>
	  </div>
	</div>
	</div>
@stop