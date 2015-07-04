<div class="row">
	<div class="col-md-6">
		@if ($thread->moved && $forum->id != $thread->forum->id)
			<a class="thread-title" alt="{{{ $thread->name }}}" data-toggle="tooltip" data-placement="top" data-original-title="{{{ $thread->name }}}" href="/{{ $thread->forum->id }}/{{ $thread->forum->slug() }}/{{ $thread->id }}/{{ $thread->slug() }}"><small>{{{ str_limit('Moved to:'. $thread->forum->name, 50, ' [...]') }}}</small>
				@else
					@if ( $thread->new_posts )
						<img data-toggle="tooltip" data-placement="top" data-original-title="{{{ $thread->unread_posts }}}" src="//static.getmonero.org/images/icon_thread_new.png">
					@else
						<img src="//static.getmonero.org/images/icon_thread.png">
					@endif
					<a class="thread-title" data-toggle="tooltip" data-placement="top" data-original-title="{{{ $thread->name }}}" href="/{{ $forum->id }}/{{ $forum->slug() }}/{{ $thread->id }}/{{ $thread->slug() }}">
						@endif {{{ str_limit($thread->name, 50, ' [...]') }}}</a>
	</div>
	<div class="col-md-4">
		<p>Author: <b><a class="board-meta" href="/user/{{ $thread->user->username }}">{{ $thread->user->username }}</a></b>, {{ $thread->created_at->formatLocalized('%A %d %B %Y') }}</p>
	</div>
	<div class="col-md-2 thread-replies">
		<p>Replies: <b>{{ $thread->posts()->count() - 1}}</b></p>
	</div>
	@if($thread->funding)
		@include('forums.includes.funding')
	@endif
</div>