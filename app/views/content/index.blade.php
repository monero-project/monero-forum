@extends('master')

@section('content')
<div class="row">
    <div class="col-lg-12 user-block">
    @if (Auth::check())
    	Welcome back, <a class="name" href="{{{ URL::to('/user/profile') }}}">{{{ Auth::user()->username }}}</a>. <a class="action-link" href="{{{ URL::to('logout') }}}">Logout</a>
    	<br>
    @else
    	Please <a href="/login" class="link-disabled login-modal action-link">login</a> or <a href="/register" class="link-disabled action-link" data-toggle="modal" data-target="#registerModal">register</a>.
    @endif
    </div>
</div>

<div class="row category-block">    
@foreach ($categories as $category)
	<div class="panel panel-default">
	  <div class="panel-heading">
	    <h3 class="panel-title"><span class="glyphicon glyphicon-th"></span> {{ $category->name }}</h3>
	  </div>
	  <div class="panel-body">
		  @foreach ($category->forums as $forum)
		  <div class="row forum-block">
			  <div class="col-md-1 forum-icon-active">
			  </div>
			  <div class="col-md-6 forum-info">
				  <h4><a href="{{ $forum->slug() }}/{{ $forum->id }}">{{ $forum->name }}</a></h4>
				  <p>{{ $forum->description }}</p>	  
			  </div>
			  <div class="col-md-3 forum-post">
			  	<p class="stats-post-body">{{ e(str_limit($forum->latest_post()->body, 57, '...')) }}<br>
				By: <b>{{ User::find($forum->latest_post()->user_id)->username }}</b>
			  	</p>
			  </div>
			  <div class="col-md-2 forum-counts">
			  	<p><b>{{ $forum->thread_count() }}</b> threads<br>
			  	<b>{{ $forum->reply_count() }}</b> replies</p>
			  </div>
		  </div>
		  @endforeach
	  </div>
	</div>
@endforeach
</div>
@stop