<p>Hello {{ $user->username }},</p>
<p>A thread you are subscribed to on the Monero Forum has been updated by {{{ $post->user->username }}}:</p>
<p><b>{{{ str_limit($post->thread->name, 30, '[...]') }}}</b></p>
{{ $post->body }}
<p>There may be more replies this thread received after this email notification. <a href="{{ URL::route('thread.short', [$post->thread_id]) }}">Click here to visit the thread</a>.</p>
<p>Regards,</p>
<p>The Monero Project Team</p>