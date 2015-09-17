@if (Auth::check() && !$post->deleted_at)
	<span class="meta-buttons pull-right">
		@if(Auth::check() && (Auth::user()->hasRole('Admin') || Auth::user()->hasRole('Moderator')) && !$post->is_sticky)
		<a href="{{ route('post.stick', [$post->id]) }}"><button class="btn btn-default btn-xs"><i class="fa fa-thumb-tack"></i> Stick</button></a>
		@elseif(Auth::check() && (Auth::user()->hasRole('Admin') || Auth::user()->hasRole('Moderator')) && $post->is_sticky)
		<a href="{{ route('post.stick', [$post->id]) }}"><button class="btn btn-default btn-xs"><i class="fa fa-thumb-tack"></i> Unstick</button></a>
		@endif
		@if(Auth::check() && $post->is_unread)
			<button type="button" class="btn btn-default btn-xs next-unread" unread-id="{{ $unread_count }}"><i class="fa fa-forward"></i> Next Unread</button>
		@endif
		@if (Auth::check() && (Auth::user()->hasRole('Admin') || Auth::user()->hasRole('Moderator')))
			<a href="/mod/delete/post/{{ $post->id }}"><button type="button" class="btn btn-default btn-xs"><i class="fa fa-trash"></i> Mod Delete</button></a>
		@endif
		@if (Auth::check())
			<a href="/votes/vote/?post_id={{ $post->id }}&vote=insightful" class="disabled-link" onclick="vote({{ $post->id }}, 'insightful')">
				@if (Vote::voted_insightful($post->id))
					<button type="button" class="disabled btn btn-default btn-xs insightful-{{ $post->id }}"><i class="fa fa-thumbs-up"></i> Insightful</button>
				@else
					<button type="button" class="btn btn-default btn-xs insightful-{{ $post->id }}"><i class="fa fa-thumbs-up"></i> Insightful</button>
				@endif
			</a>
			<a href="/votes/vote/?post_id={{ $post->id }}&vote=irrelevant" class="disabled-link" onclick="vote({{ $post->id }}, 'irrelevant')">
				@if (Vote::voted_irrelevant($post->id))
					<button type="button" class="disabled btn btn-default btn-xs irrelevant-{{ $post->id }}"><i class="fa fa-thumbs-down"></i> Irrelevant</button>
				@else
					<button type="button" class="btn btn-default btn-xs irrelevant-{{ $post->id }}"><i class="fa fa-thumbs-down"></i> Irrelevant</button>
				@endif
			</a>
			<a href="/posts/reply/{{ $post->id }}" class="post-action-btn"><button type="button" onclick="post_reply({{ $post->id }}, {{ $thread_id }}, '{{ $post->title }}')" class="btn btn-default btn-xs"><i class="fa fa-arrow-left"></i>
					Reply</button></a>
			@if ($post->user->id != Auth::user()->id)
				@if(Input::has('page'))
					<a href="/posts/report/{{ $post->id }}/{{ Input::get('page') }}"><button type="button" class="btn btn-default btn-xs"><i class="fa fa-flag"></i>
							Flag</button></a>
				@else
					<a href="/posts/report/{{ $post->id }}/1"><button type="button" class="btn btn-default btn-xs"><i class="fa fa-flag"></i>
							Flag</button></a>
				@endif
			@endif
			@if ($post->user->id == Auth::user()->id || Auth::user()->hasRole('Admin'))
				<a href="/posts/update/{{ $post->id }}" class="post-action-btn"><button type="button" onclick="post_edit({{ $post->id }}, {{ $thread_id }}, '{{ $post->title }}')" class="btn btn-default btn-xs"><i class="fa fa-pencil"></i>
						Edit</button></a>
				<a class="post-action-btn" href="/posts/delete/page/{{ $post->id }}"><button type="button" onclick="post_delete({{ $post->id }})" class="btn btn-default btn-xs"><i class="fa fa-pencil"></i>
						Delete</button></a>
			@endif
		@endif
	</span>
@endif