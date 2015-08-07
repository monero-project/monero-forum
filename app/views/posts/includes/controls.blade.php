@if (Auth::check() && !$post->deleted_at)
	<span class="meta-buttons pull-right">
		@if(Auth::check() && $post->is_unread)
			<button type="button" class="btn btn-default btn-xs next-unread" unread-id="{{ $unread_count }}"><i class="fa fa-forward"></i> Next Unread</button>
		@endif
		@if (Auth::check() && (Auth::user()->hasRole('Admin') || Auth::user()->hasRole('Moderator')))
			<a href="/mod/delete/post/{{ $post->id }}"><button type="button" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-trash"></span> Mod Delete</button></a>
		@endif
		@if (Auth::check())
			<a href="/votes/vote/?post_id={{ $post->id }}&vote=insightful" class="disabled-link" onclick="vote({{ $post->id }}, 'insightful')">
				@if (Vote::voted_insightful($post->id))
					<button type="button" class="disabled btn btn-default btn-xs insightful-{{ $post->id }}"><span class="glyphicon glyphicon-thumbs-up"></span> Insightful</button>
				@else
					<button type="button" class="btn btn-default btn-xs insightful-{{ $post->id }}"><span class="glyphicon glyphicon-thumbs-up"></span> Insightful</button>
				@endif
			</a>
			<a href="/votes/vote/?post_id={{ $post->id }}&vote=irrelevant" class="disabled-link" onclick="vote({{ $post->id }}, 'irrelevant')">
				@if (Vote::voted_irrelevant($post->id))
					<button type="button" class="disabled btn btn-default btn-xs irrelevant-{{ $post->id }}"><span class="glyphicon glyphicon-thumbs-down"></span> Irrelevant</button>
				@else
					<button type="button" class="btn btn-default btn-xs irrelevant-{{ $post->id }}"><span class="glyphicon glyphicon-thumbs-down"></span> Irrelevant</button>
				@endif
			</a>
			<a href="/posts/reply/{{ $post->id }}" class="post-action-btn"><button type="button" onclick="post_reply({{ $post->id }}, {{ $thread_id }}, '{{ $post->title }}')" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-arrow-left"></span>
					Reply</button></a>
			@if ($post->user->id != Auth::user()->id)
				@if(Input::has('page'))
					<a href="/posts/report/{{ $post->id }}/{{ Input::get('page') }}"><button type="button" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-flag"></span>
							Flag</button></a>
				@else
					<a href="/posts/report/{{ $post->id }}/1"><button type="button" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-flag"></span>
							Flag</button></a>
				@endif
			@endif
			@if ($post->user->id == Auth::user()->id || Auth::user()->hasRole('Admin'))
				<a href="/posts/update/{{ $post->id }}" class="post-action-btn"><button type="button" onclick="post_edit({{ $post->id }}, {{ $thread_id }}, '{{ $post->title }}')" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-pencil"></span>
						Edit</button></a>
				<a class="post-action-btn" href="/posts/delete/page/{{ $post->id }}"><button type="button" onclick="post_delete({{ $post->id }})" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-trash"></span>
						Delete</button></a>
			@endif
		@endif
	</span>
@endif