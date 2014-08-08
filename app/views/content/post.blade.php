<div id="post-{{ $post->id }}" class="post col-lg-12 level-{{ $level }}">
			<h4>
			@if ($post->children()->count() > 0)
			<span class="drawer-button drawer-buttons-{{ $post->id }}" style="display: none;"><span onClick="drawer_close({{ $post->id }})" class="glyphicon glyphicon-collapse-up"></span></span>
			@endif
			 {{ $post->title }}
			@if ($post->children()->count() > 0)
			 <small>Replies: {{ $post->children()->count() }}</small>
			@endif
			</h4>
			<p class="post-meta"><a href="/user/{{ $post->user->id }}" target="_blank">{{ $post->user->username }}</a> posted this on {{ $post->created_at }}</p>
			{{ Markdown::string(e($post->body)) }}
			<div class="btn-group btn-group-sm post-buttons">
			  @if (Auth::check())
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
			</div>
</div>

{{ display_posts($post->id, $thread_id, $level + 1) }}