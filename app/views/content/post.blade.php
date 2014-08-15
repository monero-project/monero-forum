<div class="post-indent">
	<div id="post-{{ $post->id }}" class="post col-lg-12 level-{{ $level }}">
		<div class="panel panel-default post-panel">
		  <div class="panel-heading">
		  			<span class="dark-green glyphicon glyphicon-user"></span> <a href="/user/{{ $post->user->id }}" target="_blank">{{ $post->user->username }}</a> posted this on <span class="date">{{ $post->created_at }}</span>
		  			@if ($post->children()->count() > 0)
					 <small>Replies: {{ $post->children()->count() }}</small>
					@endif
					@if (Auth::check())
		  			<span class="meta-buttons pull-right">
						   @if (Auth::check())
								@if (Auth::check())
							<a href="/" class="disabled-link" onclick="vote({{ $post->id }}, 'insightful')">
								@if (Vote::voted_insightful($post->id))
								<button type="button" class="disabled btn btn-default btn-xs insightful-{{ $post->id }}"><span class="glyphicon glyphicon-thumbs-up"></span> Insightful</button>
								@else
								<button type="button" class="btn btn-default btn-xs insightful-{{ $post->id }}"><span class="glyphicon glyphicon-thumbs-up"></span> Insightful</button>
								@endif
							</a> 
							<a href="/" class="disabled-link" onclick="vote({{ $post->id }}, 'irrelevant')">
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
						  @if ($post->children()->count() > 0)
							<span class="drawer-button drawer-buttons-{{ $post->id }}" style="display: none;"><span onClick="drawer_close({{ $post->id }})" class="glyphicon glyphicon-collapse-up"></span></span>
						  @endif
						</div>
			  			</span>
			  			@endif
		  <div class="panel-body">
		    <div class="post-content-{{ $post->id }}">
				@if ($post->trashed())
				<p><em>[deleted]</em></p>
				@else
				{{ Markdown::string(e($post->body)) }}
				@endif
			</div>
		  </div>
		</div>
	</div>
	{{ display_posts($post->id, $thread_id, $level + 1) }}
</div>