<div class="row thread-controls">
	<button class="btn btn-sm btn-primary no-js" id="expand-all"><i class="fa fa-plus-square"></i> Expand All</button>
	<button class="btn btn-sm btn-primary no-js" id="collapse-all"><i class="fa fa-minus-square"></i> Collapse All</button>
	@if(Auth::check())
		@if(Auth::check() && !Auth::user()->subscriptions()->where('thread_id', $thread->id)->first())
			<a href="{{ URL::route('subscriptions.subscribe', [$thread->id]) }}"><button class="btn btn-sm btn-primary"><i class="fa fa-eye"></i> Subscribe</button></a>
		@elseif(Auth::check() && Auth::user()->subscriptions()->where('thread_id', $thread->id)->first())
			<a href="{{ URL::route('subscriptions.unsubscribe', [$thread->id]) }}"><button class="btn btn-sm btn-primary"><i class="fa fa-eye-slash"></i> Unsubscribe</button></a>
		@endif
		@if ($thread->user->id == Auth::user()->id || Auth::user()->hasRole('Admin'))
			<a href="/thread/delete/{{ $thread->id }}"><button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Delete</button></a>
			<a href="/posts/update/{{ $thread->head()->id }}"><button class="btn btn-sm btn-danger"><i class="fa fa-pencil"></i> Edit</button></a>
		@endif
		@if (Auth::user()->hasRole('Admin') || Auth::user()->hasRole('Moderator'))
			<a href="/mod/move/thread/{{ $thread->id }}"><button class="btn btn-sm btn-success"><i class="fa fa-reply"></i> Move</button></a>
			<a href="/mod/delete/thread/{{ $thread->id }}"><button class="btn btn-sm btn-success"><i class="fa fa-trash"></i> Delete</button></a>
		@endif
	@endif
</div>