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
    @yield('css')
	<link href="/style.css" rel="stylesheet">
	{{--<link href="//static.getmonero.org/style.css" rel="stylesheet">--}}

    <!--[if lt IE 9]>
      <script src="//static.getmonero.org/js/html5shiv.js"></script>
      <script src="//static.getmonero.org/js/respond.min.js"></script>
    <![endif]-->

  </head>

  <body>
    <div class="navbar navbar-default navbar-static-top" role="navigation">
      <div class="navbar-wrapper">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="//getmonero.org/"><img class="logo" src="//static.getmonero.org/images/logo.svg"></a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a class="yellow" href="https://forum.getmonero.org">Forum</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle purple" data-toggle="dropdown">Blog <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="//getmonero.org/blog">All Blog Posts</a></li>
                <li><a href="//getmonero.org/blog/tags/monero%20missives">Monero Missives</a></li>
                <li><a href="//getmonero.org/blog/tags/dev%20diaries">Dev Diaries</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle red" data-toggle="dropdown">Getting Started <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="//getmonero.org/getting-started/choose">How to Choose a Monero Client</a></li>
                <li><a href="//getmonero.org/getting-started/running">How to Run a Monero Node</a></li>
                <li><a href="//getmonero.org/getting-started/donate">Donating and Sponsorships</a></li>
                <li class="divider"></li>
                <li><a href="//getmonero.org/downloads">All Monero Downloads</a></li>
                <li class="divider"></li>
                <li><a href="//getmonero.org/getting-started/accepting">Accepting Monero Payments</a></li>
				<li><a href="//getmonero.org/getting-started/merchants">Merchants and Services Directory</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle orange" data-toggle="dropdown">Knowledge Base <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="//getmonero.org/knowledge-base/about">About Monero</a></li>
                <li><a href="//getmonero.org/knowledge-base/people">The People Behind Monero</a></li>
                <li><a href="//getmonero.org/knowledge-base/moneropedia">Moneropedia</a></li>
                <li class="divider"></li>
                <li><a href="//getmonero.org/knowledge-base/user-guides">User Guides</a></li>
                <li><a href="//getmonero.org/knowledge-base/developer-guides">Developer Guides</a></li>
                <li class="divider"></li>
                <li><a href="//getmonero.org/design-goals">Design & Development Goals</a></li>
                <li><a href="//getmonero.org/research-lab">Monero Research Lab</a></li>
                <li><a href="//getmonero.org/knowledge-base/openalias">The OpenAlias Project</a></li>
                <li><a href="//getmonero.org/knowledge-base/projects">External Projects</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle softyellow last" data-toggle="dropdown">Community <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="https://forum.getmonero.org">Forum</a></li>
                <li><a href="https://www.reddit.com/r/monero/">Reddit</a></li>
                <li><a href="https://bitcointalk.org/index.php?topic=583449.0">Bitcointalk Thread</a></li>
                <li class="divider"></li>
				<li class="dropdown-header">IRC on Freenode</li>
                <li><a href="irc://chat.freenode.net/#monero">#monero (General)</a></li>
                <li><a href="irc://chat.freenode.net/#monero-dev">#monero-dev (Development)</a></li>
                <li><a href="irc://chat.freenode.net/#monero-otc">#monero-otc (OTC Trading)</a></li>
                <li><a href="irc://chat.freenode.net/#monero-markets">#monero-markets (Markets)</a></li>
                <li><a href="irc://chat.freenode.net/#monero-pools">#monero-pools (Mining)</a></li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </div>

    <div class="container main-content">
    @if (Session::has('messages'))
	<div class="row">
		<div class="alert alert-info fade in" role="alert">
		    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
		    @foreach(Session::pull('messages') as $message)
		    <p>{{ $message }}</p>
		    @endforeach
		  </div>
	</div>
	@endif
	@if (Session::has('errors'))
	<div class="row">
		<div class="alert alert-danger fade in" role="alert">
		    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
		    @foreach(Session::pull('errors') as $error)
		    <p>{{ $error }}</p>
		    @endforeach
		  </div>
	</div>
	@endif
	    @include('includes.userbar')
	<div class="row">
		{{ Breadcrumbs::addCssClasses('breadcrumb') }}
		{{ Breadcrumbs::render() }}
	</div>
		@yield('content')
    </div>

	<div class="footer">
      <div class="container">
          <div class="footer-links">
	          <ul class="fa-ul">
		          <li><i class="fa-li fa fa-dot-circle-o"></i><a href="//getmonero.org/legal/terms">Terms</a></li>
		          <li><i class="fa-li fa fa-dot-circle-o"></i><a href="//getmonero.org/legal/privacy">Privacy</a></li>
		          <li><i class="fa-li fa fa-dot-circle-o"></i><a href="//getmonero.org/legal/copyright">Copyright</a></li>
	          </ul>
      </div>
          <a class="footer-icon" href="https://getmonero.org/feed.xml"><i class="fa fa-2x fa-rss-square"></i></a>
          <a class="footer-icon" href="mailto:dev@getmonero.org"><i class="fa fa-2x fa-envelope-square"></i></a>
    </div>
    </div>

    @yield('modals')

    <!-- JS -->
    <script src="/scripts.js"></script>
    {{--<script src="//static.getmonero.org/scripts.js"></script>--}}
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
