@if(Auth::check())
<div class="media markdown-toolbar col-lg-12 post-reply-form post-reply-form-{{ $post->id }}" id="post-reply-form-{{ $post->id }}" style="display: none;" >
	<div class="pull-left">
		<img class="media-object reply-box-avatar" src="/uploads/profile/small_{{ Auth::user()->profile_picture }}" alt="{{ Auth::user()->username }} Profile Picture">
	</div>
	<div class="media-body">
		<form role="form" action="/posts/submit" method="POST">
			<input type="hidden" name="post_id" value="{{ $post->id }}">
			<input type="hidden" name="thread_id" value="{{ $post->thread_id }}">
			<div class="form-group">
				<textarea class="form-control markdown-editor" name="body" id="reply-body" rows="2" placeholder="Your insightful masterpiece goes here..."></textarea>
			</div>
			<div class="pull-left">
				<p>For post formatting please use Kramdown, <a href="http://kramdown.gettalong.org/syntax.html">click here</a> for a syntax guide.</p>
			</div>
			<div class="markdown-form-buttons">
				<button name="submit" type="submit" class="btn btn-sm btn-success">Reply</button>
				<button type="button" onclick="cancel_post_reply({{ $post->id }})" class="btn btn-danger btn-sm reply-cancel">Cancel</button>
			</div>
		</form>
	</div>
</div>
@endif