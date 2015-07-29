<div class="post-indent">
	<div id="post-{{ $post->id }}" class="post col-lg-12 @if ($level % 2 != 0) odd @endif level-{{ $level }}" parents="{{ $serialized_bread }}" head="{{ $head->id or "" }}" children="{{ $children }}">
		{{--Head at: {{ $head->id or "" }}--}}
		{{--Post id: {{ $post->id }}--}}
		{{--Parents: {{ $serialized_bread }}--}}
		{{--Children: {{ $children }}--}}
		@include('posts.includes.breadcrumbs')
		<div class="expand-label expand-label-{{ $post->id }}"></div>
		<div class="panel panel-default post-panel @if ($post->is_unread) post-unread @endif">
			<div class="panel-heading">
				<img class="profile-picture-sm" src="/uploads/profile/small_{{ $post->user->profile_picture }}"><a class="user-post-{{$post->id}}" href="/user/{{ $post->user->username }}" target="_blank">{{ $post->user->username }}</a> <span class="mobile-hide-text">posted </span> <span class="date" data-toggle="tooltip" data-placement="top" title="{{ $post->created_at }}">{{ $post->created_at->diffForHumans() }}</span>
				<small>
					@if ($post->children()->count())
						Replies: {{ $post->children()->count() }} |
					@endif
					Weight: {{ $post->weight }} | <a class="meta-permalink" href='{{ $post->thread->permalink()."?page=".Input::get('page')."&noscroll=1#post-".$post->id }}'>Link</a>
				</small>
				<small class="content-control content-control-{{ $post->id }}">
					@if ($post->is_hidden)
						<span onclick="content_show({{ $post->id }})">[ + ]</span>
					@else
						<span onclick="content_hide({{ $post->id }})">[ - ]</span>
					@endif
				</small>
				@include('posts.includes.controls')
			</div>
			<div class="panel-body content-block content-block-{{ $post->id }}  @if ($post->is_hidden) hidden-post-content @endif" id="{{ $post->id }}">
				<div class="post-content-{{ $post->id }} video-integration">
					@if ($post->trashed())
						<p><em>[deleted]</em></p>
					@else
						@if(Auth::check() && $post->user_id == Auth::user()->id)
							<div class="markdown-inline-edit post-{{ $post->id }}-markdown-edit">
								{{ $post->body }}
							</div>
						@else
							{{ $post->body }}
						@endif
					@endif
					@include('posts.includes.mobile_controls')
				</div>
			</div>
		</div>
		@include('posts.includes.reply')
		@include('posts.includes.nest')
	</div>
</div>