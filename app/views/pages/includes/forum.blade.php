@if (Visibility::check('forum', $forum->id))
	<div class="row forum-block">
		<div class="col-md-1">
			@if($forum->unread_posts > 0)
				<i class="forum-icon-active fa fa-comments" data-toggle="tooltip" data-placement="top" data-original-title="{{{ $forum->unread_posts }}}" ></i>
			@else
				<i class="forum-icon-active fa fa-comments-o forum-read"></i>
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
					<br>
					{{{ $forum->latest_thread()->latest_post()->created_at->formatLocalized('%A %d %B %Y') }}}
				@endif
			</p>
		</div>
		<div class="col-md-2 forum-counts">
			<p><b>{{ $forum->thread_count() }}</b> threads<br>
				<b>{{ $forum->reply_count() }}</b> replies</p>
		</div>
	</div>
@endif