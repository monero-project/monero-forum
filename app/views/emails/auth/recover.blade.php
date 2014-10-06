<p>Hello {{ $user->username }},</p>
<p>In order to change your password, please follow the link below:</p>
<p><a href="{{ Config::get('app.url')}}/user/recover/{{$user->id}}/{{$user->recovery_token}}">{{ Config::get('app.url')}}/user/recover/{{$user->id}}/{{$user->recovery_token}}</a></p>
<p>Regards,</p>
<p>The Monero Project Team</p>