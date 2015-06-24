<p>Hello {{ $user->username }},</p>
<p>In order to complete your registration, please click the link below</p>
<p><a href="{{ Config::get('app.url')}}/user/activate/{{$user->id}}/{{$user->confirmation_code}}">{{ Config::get('app.url')}}/user/activate/{{$user->id}}/{{$user->confirmation_code}}</a></p>
<p>Regards,</p>
<p>The Monero Project Team</p>
