<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@if(isset($title)){{ $title }}@else{{ 'Monero | Forum' }}@endif</title>

    <link rel="apple-touch-icon" sizes="57x57" href="/apple-touch-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/apple-touch-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/apple-touch-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/apple-touch-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/apple-touch-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/apple-touch-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/apple-touch-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon-180x180.png">
    <link rel="icon" type="image/png" href="/favicon-32x32.png" sizes="32x32">
    <link rel="icon" type="image/png" href="/favicon-194x194.png" sizes="194x194">
    <link rel="icon" type="image/png" href="/favicon-96x96.png" sizes="96x96">
    <link rel="icon" type="image/png" href="/android-chrome-192x192.png" sizes="192x192">
    <link rel="icon" type="image/png" href="/favicon-16x16.png" sizes="16x16">
    <link rel="manifest" href="/manifest.json">
    <meta name="msapplication-TileColor" content="#2d89ef">
    <meta name="msapplication-TileImage" content="/mstile-144x144.png">
    <meta name="theme-color" content="#ffffff">
	@yield('description')
	<meta name="keywords" content="monero, xmr, bitmonero, cryptocurrency, crypto money, mining crypto currencies, virtual currency">

    @yield('css')

	@if(App::environment() == 'local')
	<link href="/style.css" rel="stylesheet">
	@else
	<link href="//static.getmonero.org/style.css" rel="stylesheet">
	@endif

    <!--[if lt IE 9]>
      <script src="//static.getmonero.org/js/html5shiv.js"></script>
      <script src="//static.getmonero.org/js/respond.min.js"></script>
    <![endif]-->

  </head>

  <body>
	@include('includes.navbar')

    <div class="container main-content">

	    @include('includes.fundswarning')
	    @include('includes.messages')
	    @include('includes.userbar')
		@include('includes.breadcrumbs')

		@yield('content')

    </div>

	<div class="footer">
      <div class="container">
          <div class="footer-links">
	          <ul class="fa-ul">
		          <li><i class="fa-li fa fa-dot-circle-o"></i><a href="//getmonero.org/legal">Legal</a></li>
		          <li><i class="fa-li fa fa-dot-circle-o"></i><a href="https://github.com/monero-project/monero-forum">Source Code</a></li>
	          </ul>
      </div>
          <a class="footer-icon" href="https://getmonero.org/feed.xml"><i class="fa fa-2x fa-rss-square"></i></a>
          <a class="footer-icon" href="mailto:dev@getmonero.org"><i class="fa fa-2x fa-envelope-square"></i></a>
    </div>
    </div>

    @yield('modals')

    <!-- JS -->
	@if(App::environment() == 'local')
    <script src="/scripts.js"></script>
    @else
    <script src="//static.getmonero.org/scripts.js"></script>
    @endif
	<script>
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		ga('create', 'UA-53312765-5', 'auto');
		ga('require', 'linkid', 'linkid.js');
		ga('send', 'pageview');
	</script>

    @yield('javascript')

  </body>
</html>
@if (Auth::check())
{{ NULL; Auth::user()->touch() }}
@endif
