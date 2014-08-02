<div id="post-{{ $post->id }}" class="post col-lg-12 level-{{ $level }}">
			<h4>{{ $post->title }}</h4>
			<p class="post-meta"><a href="/user/{{ $post->user->id }}" target="_blank">{{ $post->user->username }}</a> posted this on {{ $post->created_at }}</p>
			{{ Markdown::string(e($post->body)) }}
			<div class="btn-group btn-group-sm post-buttons">
			  <button type="button" onclick="post_reply({{ $post->id }}, {{ $thread_id }}, '{{ $post->title }}')" class="btn btn-default"><span class="glyphicon glyphicon-arrow-left"></span>
 Reply</button>
 			  @if ($post->user->id != Auth::user()->id)
			  <button type="button" class="btn btn-default"><span class="glyphicon glyphicon-flag"></span>
 Flag</button>
 			  @endif
			  @if ($post->user->id == Auth::user()->id)
			  <button type="button" class="btn btn-default"><span class="glyphicon glyphicon-pencil"></span>
 Edit</button>
			  <button type="button" class="btn btn-default"><span class="glyphicon glyphicon-trash"></span>
 Delete</button>
			  @endif
			</div>
</div>
{{ display_children($post->id, $thread_id, $level + 1) }}