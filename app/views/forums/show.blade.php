@extends('master')

@section('description')
	<meta name="description" content="{{ $forum->description }}" />
@stop

@section('content')
{{ Breadcrumbs::addCrumb('Home', '/') }}
{{ Breadcrumbs::addCrumb(e($forum->category->name), '/#category-'.$forum->category->id) }}
{{ Breadcrumbs::addCrumb(e($forum->name), $forum->permalink()) }}
@if (Visibility::check('forum', $forum->id))
<div class="row category-block">   
<div class="panel panel-default">
  <div class="panel-heading">
    <h1 class="panel-title"><i class="fa fa-th-list"></i> {{ $forum->name }} <a class="pull-right normal-create" href="/thread/create/{{ $forum->id }}"><button class="btn btn-xs create-thread btn-primary pull-right"><i class="fa fa-plus"></i>Create a Thread</button></a>
    <a href="/users/action/allread/{{ $forum->id }}" alt="Mark forum as read" class="pull-right normal-create"><button class="btn btn-xs create-thread btn-primary pull-right mark-read"><i class="fa fa-check"></i>Mark as Read</button></a>
	</h1>
  </div>
  <div class="row mobile-create">
	  <a href="/thread/create/{{ $forum->id }}"><button class="btn full-width btn-success">Create a Thread</button></a>
  </div>
  <div class="panel-body thread-list">
	@if($queued && sizeof($queued))
		<h4>Your threads in this forum are awaiting moderation:</h4>
	    @foreach($queued as $item)
			<div class="row">
				<div class="col-lg-12">
					{{{ $item->name }}}
				</div>
			</div>
        @endforeach
    @endif
    @foreach ($threads as $thread)
    @include('forums.includes.thread')
	@endforeach
  </div>
</div>
</div>
<div class="post-links">
	{{ $threads->links() }}
</div>
@else
{{ App::abort(404); }}
@endif
@stop