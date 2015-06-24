<p>Hello {{{ $receiver->username }}},</p>
<p>You have a new private message on the Monero Forum from {{{ $sender->username  }}}:</p>
<p><b>{{{ str_limit($pm->conversation->title, 30, '[...]') }}}</b></p>
{{ Markdown::string(e($pm->body)) }}
<p><a href="{{ URL::route('messages.conversation', [$pm->conversation_id]) }}">Click here to read and reply to this message</a>.</p>
<p>Regards,</p>
<p>The Monero Project Team</p>