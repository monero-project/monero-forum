<div class="row thread-controls">
	<button class="btn btn-sm btn-primary no-js" id="expand-all"><i class="fa fa-arrows-alt"></i> Expand All</button>
	@if(Auth::check() && !Auth::user()->subscriptions()->where('thread_id', $thread->id)->first())
		<a href="{{ URL::route('subscriptions.subscribe', [$thread->id]) }}"><button class="btn btn-sm btn-primary"><span class="glyphicon glyphicon-eye-open"></span> Subscribe</button></a>
	@elseif(Auth::check() && Auth::user()->subscriptions()->where('thread_id', $thread->id)->first())
		<a href="{{ URL::route('subscriptions.unsubscribe', [$thread->id]) }}"><button class="btn btn-sm btn-primary"><span class="glyphicon glyphicon-eye-close"></span> Unsubscribe</button></a>
	@endif
	@if ($thread->user->id == Auth::user()->id || Auth::user()->hasRole('Admin'))
		<a href="/thread/delete/{{ $thread->id }}"><button class="btn btn-sm btn-danger"><span class="glyphicon glyphicon-trash"></span> Delete</button></a>
		<a href="/posts/update/{{ $thread->head()->id }}"><button class="btn btn-sm btn-danger"><span class="glyphicon glyphicon-pencil"></span> Edit</button></a>
	@endif
	@if (Auth::user()->hasRole('Admin') || Auth::user()->hasRole('Moderator'))
		<a href="/mod/move/thread/{{ $thread->id }}"><button class="btn btn-sm btn-success"><span class="glyphicon glyphicon-share-alt"></span> Move</button></a>
		<a href="/mod/delete/thread/{{ $thread->id }}"><button class="btn btn-sm btn-success"><span class="glyphicon glyphicon-trash"></span> Delete</button></a>
	@endif
</div>