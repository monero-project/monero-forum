@if (Auth::check())
	<div class="mobile-meta-buttons">
			<a href="/votes/vote/?post_id={{ $post->id }}&vote=insightful" class="disabled-link" onclick="vote({{ $post->id }}, 'insightful')">
				@if (Vote::voted_insightful($post->id))
					<button type="button" class="disabled btn btn-default btn-xs insightful-{{ $post->id }}"><span class="glyphicon glyphicon-thumbs-up"></span> </button>
				@else
					<button type="button" class="btn btn-default btn-xs insightful-{{ $post->id }}"><span class="glyphicon glyphicon-thumbs-up"></span> </button>
				@endif
			</a>
			<a href="/votes/vote/?post_id={{ $post->id }}&vote=irrelevant" class="disabled-link" onclick="vote({{ $post->id }}, 'irrelevant')">
				@if (Vote::voted_irrelevant($post->id))
					<button type="button" class="disabled btn btn-default btn-xs irrelevant-{{ $post->id }}"><span class="glyphicon glyphicon-thumbs-down"></span> </button>
				@else
					<button type="button" class="btn btn-default btn-xs irrelevant-{{ $post->id }}"><span class="glyphicon glyphicon-thumbs-down"></span> </button>
				@endif
			</a>
			<a href="/posts/reply/{{ $post->id }}" class="post-action-btn"><button type="button" onclick="post_reply({{ $post->id }}, {{ $thread_id }}, '{{ $post->title }}')" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-arrow-left"></span>
				</button></a>
			@if ($post->user->id != Auth::user()->id)
				@if (!Input::has('page'))
					<a href="/posts/report/{{ $post->id }}/1" class="post-action-btn"><button type="button" onclick="post_flag({{ $post->id }})" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-flag"></span></button></a>
				@else
					<a href="/posts/report/{{ $post->id }}/{{ Input::get('page') }}" class="post-action-btn"><button type="button" onclick="post_flag({{ $post->id }})" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-flag"></span></button></a>
				@endif
			@endif
			@if ($post->user->id == Auth::user()->id)
				<a href="/posts/update/{{ $post->id }}" class="post-action-btn"><button type="button" onclick="post_edit({{ $post->id }}, {{ $thread_id }}, '{{ $post->title }}')" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-pencil"></span></button></a>
						<a class="post-action-btn" href="/posts/delete/page/{{ $post->id }}"><button type="button" onclick="post_delete({{ $post->id }})" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-trash"></span></button></a>
			@endif
	</div>
@endif
@if ($post->children()->count())
	@if ($post->weight < Config::get('app.hidden_weight'))
		<span class="mobile-drawer drawer-button drawer-buttons-{{ $post->id }} pull-right" style="display: none; padding-left: 5px; padding-top: 3px;"><span onClick="drawer_open({{ $post->id }})" class="glyphicon glyphicon-collapse-down"></span></span>
	@else
		<span class="mobile-drawer drawer-button drawer-buttons-{{ $post->id }} pull-right" style="display: none; padding-left: 5px; padding-top: 3px;"><span onClick="drawer_close({{ $post->id }})" class="glyphicon glyphicon-collapse-up"></span></span>
	@endif
@endif