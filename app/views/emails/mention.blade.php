<p>Hello {{ $username }},</p>
<p>You have been mentioned in a post by {{{ $mentioned_by }}}:</p>
<p><b>{{{ str_limit($title, 30, '[...]') }}}</b></p>
{{ $body }}
<p>There may be more replies this thread received after this email notification. <a href="{{ URL::route('thread.short', [$thread_id]) }}">Click here to visit the thread</a>.</p>
<p>Regards,</p>
<p>The Monero Project Team</p>