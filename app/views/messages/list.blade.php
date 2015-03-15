@extends('master')

@section('content')
	<div class="row">
		<div class="operations">
			<a href="/messages/create"><button class="btn btn-success pull-right"><span class="glyphicon glyphicon-plus"></span> New Conversation</button></a>
		</div>
	</div>
	<div class="row category-block">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h1 class="panel-title"><span class="glyphicon glyphicon-envelope"></span> Private Messages</h1>
				</div>
				<div class="panel-body thread-list">
					@foreach ($conversations as $conversation)
						<div class="row">
							<div class="col-md-6">
									<span class="glyphicon glyphicon-envelope"></span>
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

@section('javascript')
	<script type="text/javascript">
		$(function () {
			$("[data-toggle='tooltip']").tooltip();
		});
	</script>
@stop