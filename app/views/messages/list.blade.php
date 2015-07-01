@extends('master')

@section('content')

	{{ Breadcrumbs::addCrumb('Home', '/') }}
	{{ Breadcrumbs::addCrumb('Messages', '/messages') }}

	<div class="row">
		<div class="operations">
			<a href="/messages/create"><button class="btn btn-success pull-right"><span class="glyphicon glyphicon-plus"></span> New Conversation</button></a>
		</div>
	</div>
	<div class="row category-block">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h1 class="panel-title"><i class="fa fa-envelope"></i> Private Messages</h1>
				</div>
				<div class="panel-body thread-list">
					@foreach ($conversations as $conversation)
						<div class="row message-list">
							<div class="col-md-6">
								@if($conversation->is_read())
									<i class="fa fa-envelope-o"></i>
								@else
									<i class="fa fa-envelope envelope-green"></i>
								@endif
									<a class="thread-title" data-toggle="tooltip" data-placement="top" data-original-title="{{{ $conversation->title }}}" href="{{ URL::route('messages.conversation', [$conversation->id]) }}">
										{{{ str_limit($conversation->title, 50, ' [...]') }}}
									</a>
							</div>
							<div class="col-md-4">
								<p>Participants:
									<b><a class="board-meta" href="/user/{{ $conversation->user->username }}">{{ $conversation->user->username }}</a></b>
									<b><a class="board-meta" href="/user/{{ $conversation->receiver->username }}">{{ $conversation->receiver->username }}</a></b>
									, {{ $conversation->created_at }}
								</p>
							</div>
							<div class="col-md-2 thread-replies">
								<p>Messages: <b>{{ $conversation->messages->count() }}</b></p>
							</div>
						</div>
					@endforeach
				</div>
			</div>
		</div>
		<div class="post-links">
			{{ $conversations->links() }}
		</div>
@stop