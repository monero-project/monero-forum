<div class="post-indent">
	<div id="post-{{ $post->id }}" class="post col-lg-12 level-{{ $level }}">
		<div class="panel panel-default post-panel">
		  <div class="panel-heading">
		  			<span class="dark-green glyphicon glyphicon-user"></span> <a href="/user/{{ $post->user->id }}" target="_blank">{{ $post->user->username }}</a> <span class="mobile-hide-text">posted this on</span> <span class="date">{{ $post->created_at }}</span>
		  			@if ($post->children()->count() > 0)
					 <small>Replies: {{ $post->children()->count() }}</small>
					@endif
					@if (Auth::check())
		  			<span class="meta-buttons pull-right">
						   @if (Auth::check())
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
							@endif
						  <a href="/posts/reply/{{ $post->id }}" class="post-action-btn"><button type="button" onclick="post_reply({{ $post->id }}, {{ $thread_id }}, '{{ $post->title }}')" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-arrow-left"></span>
			 Reply</button></a>
			 			  @if ($post->user->id != Auth::user()->id)
						  <a href="/posts/report/{{ $post->id }}" class="post-action-btn"><button type="button" onclick="post_flag({{ $post->id }})" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-flag"></span>
			 Flag</button></a>
			 			  @endif
						  @if ($post->user->id == Auth::user()->id)
						  <a href="/posts/update/{{ $post->id }}" class="post-action-btn"><button type="button" onclick="post_edit({{ $post->id }}, {{ $thread_id }}, '{{ $post->title }}')" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-pencil"></span>
			 Edit</button></a>
						  <a class="post-action-btn" href="/posts/delete/page/{{ $post->id }}"><button type="button" onclick="post_delete({{ $post->id }})" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-trash"></span>
			 Delete</button></a>
						  @endif
						  @endif
			  			@endif
			  			@if ($post->children()->count() > 0)
						<span class="drawer-button drawer-buttons-{{ $post->id }} pull-right" style="display: none; padding-left: 5px; padding-top: 3px;"><span onClick="drawer_close({{ $post->id }})" class="glyphicon glyphicon-collapse-up"></span></span>
						@endif
			  			</span>
		  </div>
		  <div class="panel-body">
		    <div class="post-content-{{ $post->id }}">
				@if ($post->trashed())
				<p><em>[deleted]</em></p>
				@else
				{{ Markdown::string(e($post->body)) }}
				@endif
				
				@if (Auth::check())
		  			<div class="mobile-meta-buttons">
						   @if (Auth::check())
							@if (Auth::check())
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
							@endif
						  <a href="/posts/reply/{{ $post->id }}" class="post-action-btn"><button type="button" onclick="post_reply({{ $post->id }}, {{ $thread_id }}, '{{ $post->title }}')" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-arrow-left"></span>
			 </button></a>
			 			  @if ($post->user->id != Auth::user()->id)
						  <a href="/posts/report/{{ $post->id }}" class="post-action-btn"><button type="button" onclick="post_flag({{ $post->id }})" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-flag"></span>
			 </button></a>
			 			  @endif
						  @if ($post->user->id == Auth::user()->id)
						  <a href="/posts/update/{{ $post->id }}" class="post-action-btn"><button type="button" onclick="post_edit({{ $post->id }}, {{ $thread_id }}, '{{ $post->title }}')" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-pencil"></span>
			 </button></a>
						  <a class="post-action-btn" href="/posts/delete/page/{{ $post->id }}"><button type="button" onclick="post_delete({{ $post->id }})" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-trash"></span>
			 </button></a>
						  @endif
						  @endif
			  			@endif
			  			@if ($post->children()->count() > 0)
						<span class="mobile-drawer drawer-button drawer-buttons-{{ $post->id }} pull-right" style="display: none; padding-left: 5px; padding-top: 3px;"><span onClick="drawer_close({{ $post->id }})" class="glyphicon glyphicon-collapse-up"></span></span>
						@endif
			  </div>
				
			</div>
		  </div>
		</div>
	</div>
	{{ display_posts($post->id, $thread_id, $level + 1) }}
</div>