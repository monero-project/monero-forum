@extends('master')

@section('content')
{{ Breadcrumbs::addCrumb('Home', '/') }}
<div class="row category-block">    
@foreach ($categories as $category)
@if (Visibility::check('category', $category->id))
	<div class="panel panel-default">
	  <div class="panel-heading">
	    <h3 class="panel-title"><span class="glyphicon glyphicon-th"></span> {{ $category->name }}</h3>
	  </div>
	  <div class="panel-body">
		  @foreach ($category->forums as $forum)
		  @if (Visibility::check('forum', $forum->id))
		  <div class="row forum-block">
			  <div class="col-md-1">
			  @if($forum->unread_posts > 0)
			  	<span class="forum-icon-active glyphicon glyphicon-comment" data-toggle="tooltip" data-placement="top" data-original-title="{{{ $forum->unread_posts }}}" ></span>
			  @else
			    <span class="forum-icon-active glyphicon glyphicon-comment forum-read"></span>
			  @endif
			  </div>
			  <div class="col-md-6 forum-info">
				  <h4><a href="/{{ $forum->id }}/{{ $forum->slug() }}">{{ $forum->name }}</a></h4>
				  <p>{{ $forum->description }}</p>	  
			  </div>
			  <div class="col-md-3 forum-post">
			  	<p class="stats-post-body">
			  	@if ($forum->latest_post())
			  	<a class="board-meta" href="{{ $forum->latest_thread()->permalink() }}">{{ e(str_limit($forum->latest_thread()->name, 57, '...')) }}</a>
			  	<br>
				Replied By: <b><a class="board-meta" href="/user/{{{ $forum->latest_thread()->latest_post()->user->username or "" }}}">{{{ $forum->latest_thread()->latest_post()->user->username or "" }}}</a></b>
			  	@endif
			  	</p>
			  </div>
			  <div class="col-md-2 forum-counts">
			  	<p><b>{{ $forum->thread_count() }}</b> threads<br>
			  	<b>{{ $forum->reply_count() }}</b> replies</p>
			  </div>
		  </div>
		  @endif
		  @endforeach
	  </div>
	</div>
@endif
@endforeach
</div>
@stop


@section('javascript')
<script type="text/javascript">
    $(function () {
        $("[data-toggle='tooltip']").tooltip();
    });
</script>
@stop