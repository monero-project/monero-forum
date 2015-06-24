<?php

try {


?>
<div class="post-indent">
	@if ($level % 2 == 0)
		<div id="post-{{ $post->id }}" class="post col-lg-12 level-{{ $level }}"
		     parents="{{ $serialized_bread }}"
		     head="{{ $head->id or "" }}"
		     children="{{ $children }}">
	@else
		<div id="post-{{ $post->id }}" class="post col-lg-12 odd level-{{ $level }}" parents="{{ $serialized_bread }}" head="{{ $head->id or "" }}" children=" {{ $children }}">
	@endif
			{{--Head at: {{ $head->id or "" }}--}}
			{{--Post id: {{ $post->id }}--}}
			{{--Parents: {{ $serialized_bread }}--}}
			{{--Children: {{ $children }}--}}
		<div class="row post-breadcrumbs">
		@if (sizeof($breadcrumbs))
			<span class="reply-to"> Reply to: </span>
		@endif
		@foreach (($breadcrumbs) as $key => $breadcrumb)
			<a class="post-crumb" href="#post-{{ $breadcrumb->id }}" data-toggle="tooltip" data-placement="top" title="{{ str_limit(e($breadcrumb->body), 200, '...') }}" alt="{{ str_limit(e($breadcrumb->body), 200, '...') }}">{{ $breadcrumb->user->username }}</a>@if (sizeof($breadcrumbs)-1 != $key)<span class="glyphicon glyphicon-chevron-right reply-bullet"></span>@endif
		@endforeach
		</div>
		@if (
		!$post->deleted_at
		&&
		Auth::check()
		&&
		ThreadView::where('user_id', Auth::user()->id)->where('thread_id', $post->thread->id)->first()
		&&
		$post->updated_at > ThreadView::where('user_id', Auth::user()->id)->where('thread_id', $post->thread->id)->first()->updated_at
		)
		<div class="panel panel-default post-panel post-unread">
		@else
		<div class="panel panel-default post-panel">
		@endif
		  <div class="panel-heading">
		  			<img class="profile-picture-sm" src="/uploads/profile/small_{{ $post->user->profile_picture }}"><a class="user-post-{{$post->id}}" href="/user/{{ $post->user->username }}" target="_blank">{{ $post->user->username }}</a> <span class="mobile-hide-text">posted this on</span> <span class="date">{{ $post->created_at }}</span>
		  			<small>
		  			@if ($post->children()->count())
					 Replies: {{ $post->children()->count() }} | 
					@endif
					Weight: {{ $post->weight }} | <a class="meta-permalink" href='{{ $post->thread->permalink()."?page=".Input::get('page')."&noscroll=1#post-".$post->id }}'>Link</a>
					</small>
					 <small class="content-control content-control-{{ $post->id }}">
						 @if ($post->weight < Config::get('app.hidden_weight'))
						 	<span onclick="content_show({{ $post->id }})">[ + ]</span>
						 @else
						 	<span onclick="content_hide({{ $post->id }})">[ - ]</span>
						 @endif
					 </small>
					@if (Auth::check() && !$post->deleted_at)
		  			<span class="meta-buttons pull-right">
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
			  			@endif

			  			</span>
		  </div>
		  @if ($post->weight < Config::get('app.hidden_weight'))
		  <div class="panel-body content-block content-block-{{ $post->id }} hidden-post-content" id="{{ $post->id }}">
		  @else
		  <div class="panel-body content-block content-block-{{ $post->id }}" id="{{ $post->id }}">
		  @endif
		    <div class="post-content-{{ $post->id }}">
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
				
				@if (Auth::check())
		  			<div class="mobile-meta-buttons">
						   @if (Auth::check())
							@if (Auth::check()) {{-- ends --}}
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
							@endif {{-- ends --}}
						  <a href="/posts/reply/{{ $post->id }}" class="post-action-btn"><button type="button" onclick="post_reply({{ $post->id }}, {{ $thread_id }}, '{{ $post->title }}')" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-arrow-left"></span>
			 </button></a>
			 			  @if ($post->user->id != Auth::user()->id) {{-- ends --}}
			 			  	@if (!Input::has('page'))
			 			  		<a href="/posts/report/{{ $post->id }}/1" class="post-action-btn"><button type="button" onclick="post_flag({{ $post->id }})" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-flag"></span>
			 			  	@else
			 			  		<a href="/posts/report/{{ $post->id }}/{{ Input::get('page') }}" class="post-action-btn"><button type="button" onclick="post_flag({{ $post->id }})" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-flag"></span>
			 				@endif
			 				</button></a>
			 			  @endif {{-- ends --}}
						  @if ($post->user->id == Auth::user()->id) {{-- ends --}}
						  <a href="/posts/update/{{ $post->id }}" class="post-action-btn"><button type="button" onclick="post_edit({{ $post->id }}, {{ $thread_id }}, '{{ $post->title }}')" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-pencil"></span>
			 </button></a>
						  <a class="post-action-btn" href="/posts/delete/page/{{ $post->id }}"><button type="button" onclick="post_delete({{ $post->id }})" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-trash"></span>
			 </button></a>
			 			  @endif {{-- ends --}}
						  @endif
						  </div>
			   @endif 
			  			@if ($post->children()->count()) {{-- ends --}}
			  				@if ($post->weight < Config::get('app.hidden_weight'))
			  				<span class="mobile-drawer drawer-button drawer-buttons-{{ $post->id }} pull-right" style="display: none; padding-left: 5px; padding-top: 3px;"><span onClick="drawer_open({{ $post->id }})" class="glyphicon glyphicon-collapse-down"></span></span>
							@else
							<span class="mobile-drawer drawer-button drawer-buttons-{{ $post->id }} pull-right" style="display: none; padding-left: 5px; padding-top: 3px;"><span onClick="drawer_close({{ $post->id }})" class="glyphicon glyphicon-collapse-up"></span></span>
							@endif
						@endif {{-- ends --}}				
			</div>
		  </div>
		</div>
		<div class="expand-label expand-label-{{$post->id}}" style="display: none;"></div>
		<form role="form" class="col-lg-12 post-reply-form post-reply-form-{{ $post->id }}" style="display: none;" action="/posts/submit" method="POST">
			<input type="hidden" name="post_id" value="{{ $post->id }}">
			<input type="hidden" name="thread_id" value="{{ $post->thread_id }}">
			<div class="row">
				<p class="syntax">For post formatting please use Markdown, <a href="http://daringfireball.net/projects/markdown/syntax">click here</a> for a syntax guide. </p>
			</div>
			<div class="form-group row">
				<textarea class="form-control markdown-insert" data-provide="markdown" name="body" id="reply-body" rows="6" placeholder="Your insightful masterpiece goes here..."></textarea>
			</div>
			<div class="row">
				<button type="submit" class="btn btn-success btn-sm" name="submit">Submit Reply</button>
				<button type="button" onclick="cancel_post_reply({{ $post->id }})" class="btn btn-danger btn-sm reply-cancel">Cancel</button>
			</div>
		</form>
		</div>
	@if ((Input::has('sort') && Input::get('sort') == 'weight') || (!Input::has('sort') && (Auth::check() && Auth::user()->default_sort == 'weight')) || !Input::has('sort') && !Auth::check())
		{{ display_posts($post->id, $thread_id, $level + 1) }}
	@endif
</div>
<?php

}
catch(Exception $e)
{
    Log::error($e);
}
?>
