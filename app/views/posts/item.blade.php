<div class="post-indent">
	@if($post->is_sticky && !$thread_stickied)
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-body">
						<p>
							This comment has been stickied at the top of the thread! <a href="#post-{{ $post->id }}">Go to post</a>
						</p>
					</div>
				</div>
			</div>
		</div>
	@else
	<div id="post-{{ $post->id }}" class="post col-lg-12 @if ($level % 2 != 0) odd @endif level-{{ $level }} @if($thread_stickied && $post->is_sticky) sticky-post @endif" parents="{{ $serialized_bread }}" head="{{ $head->id or "" }}" children="{{ $children }}">
		{{--Head at: {{ $head->id or "" }}--}}
		{{--Post id: {{ $post->id }}--}}
		{{--Parents: {{ $serialized_bread }}--}}
		{{--Children: {{ $children }}--}}
		@include('posts.includes.breadcrumbs')
		<div class="panel panel-default post-panel @if ($post->is_unread) post-unread @endif" @if ($post->is_unread) id="unread-post-{{ $unread_count }}" @endif>
			<div class="panel-heading">
				<img class="profile-picture-sm" src="/uploads/profile/small_{{ $post->user->profile_picture }}">
					<a class="user-post-{{$post->id}}" href="/user/{{ $post->user->username }}" target="_blank">{{ $post->user->username }}</a>
						<span class="mobile-hide-text">@if($post->updated_at > $post->created_at)edited @else posted @endif</span>
						<span class="date" data-toggle="tooltip" data-placement="top" title="@if($post->updated_at > $post->created_at) {{ $post->updated_at }} @else {{ $post->created_at }} @endif">{{ $post->created_at->diffForHumans() }}</span>
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
							@if((Input::has('sort') && Input::get('sort') != 'weight' || !Input::has('sort') && Auth::check() && Auth::user()->default_sort != 'weight') && $post->parent_id)
								@if(Auth::check() && !Auth::user()->show_parent)
									<div class="show-quote"><i class="fa fa-quote-left"></i> Show parent comment.</div>
									<div class="parent-container">
										<blockquote>
											{{ $post->parent->body }}
											<footer>{{ $post->parent->user->username }} <a href="#post-{{ $post->parent_id }}">[Link]</a></footer>
										</blockquote>
									</div>
								@elseif(Auth::check() && Auth::user()->show_parent)
									<div class="show-quote active"><i class="fa fa-quote-left"></i> Hide parent comment.</div>
									<div class="parent-container" style="display: block;">
										<blockquote>
											{{ $post->parent->body }}
											<footer>{{ $post->parent->user->username }} <a href="#post-{{ $post->parent_id }}">[Link]</a></footer>
										</blockquote>
									</div>
								@endif
							@endif
							{{ $post->body }}
						@endif
					@endif
					@include('posts.includes.mobile_controls')
				</div>
			</div>
		</div>
		@include('posts.includes.reply')
		<div class="expand-label expand-label-{{ $post->id }}"></div>
		@include('posts.includes.nest')
	</div>
	@endif
</div>