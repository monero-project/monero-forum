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

    <link href="//static.getmonero.org/css/bootstrap.min.css" rel="stylesheet">
    @yield('css')
	  <link href="/css/main.css" rel="stylesheet">
	  {{--<link href="//static.getmonero.org/css/main.css" rel="stylesheet">--}}
	  <link href="/css/forum.css" rel="stylesheet">
	  <link href="/css/bootstrap-markdown.min.css" rel="stylesheet">
    {{--<link href="//static.getmonero.org/css/forum.css" rel="stylesheet">--}}

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

	<div class="row">
		  <div class="col-lg-12 user-block">
			  <div class="col-lg-6">
				  @if (Auth::check())
					  Hello,
					  <a class="name" href="{{ URL::to('/user/profile') }}">{{{ Auth::user()->username }}}</a>.
					  <a class="action-link user-block-mobile-disable" href="{{ URL::to('/messages') }}" alt="Private Messages" title="Private Messages" data-toggle="tooltip" data-placement="bottom" data-original-title="Private Messages">
						  @if(Message::unreadCount() > 0)
							  <span class="glyphicon glyphicon-envelope kicks"></span>
						  @else
							  <span class="glyphicon glyphicon-envelope"></span>
						  @endif
					  </a>
					  <a class="action-link user-block-mobile-disable" href="{{ URL::route('notifications.index') }}"  alt="Notifications" title="Notifications">
						  @if(Notification::unreadCount() > 0)
							  <span class="glyphicon glyphicon-bell kicks" data-toggle="tooltip" data-placement="bottom" data-original-title="Notifications"></span>
						  @else
						  <span class="glyphicon glyphicon-bell" data-toggle="tooltip" data-placement="bottom" data-original-title="Notifications"></span>
			              @endif
					  </a>
					  <a class="action-link user-block-mobile-disable" href="{{ URL::to('/user/settings') }}"  alt="Settings" title="Settings"><span class="glyphicon glyphicon-cog" data-toggle="tooltip" data-placement="bottom" data-original-title="Settings"></span></a>
					  <a class="action-link user-block-mobile-disable" href="{{ URL::to('/users/action/allread') }}" alt="Mark everything as read" title="Mark as Read" data-toggle="tooltip" data-placement="bottom" data-original-title="Mark forum as read"><span class="glyphicon glyphicon-book"></span></a>
					  <a class="action-link user-block-mobile-disable" href="{{ URL::to('/logout') }}" alt="Logout" title="Logout"><span class="glyphicon glyphicon-log-out" data-toggle="tooltip" data-placement="bottom" data-original-title="Log Out"></span></a>
					  <br>
				  @else
					  Please <a href="/login" class="link-disabled action-link">login</a> or <a href="/register" class="link-disabled action-link">register</a>.
				  @endif
			  </div>
			  <div class="col-lg-6 search-bar">
				  {{ Form::open(array('url' => '/search')) }}
				  <div class="col-lg-12 pull-right">
					  <div class="input-group">
						  <input type="text" name="query" class="form-control search-text" placeholder="What would you like to find?">
						  @if(Route::current() && (Route::current()->getName() == 'threadView' || Route::current()->getName() == 'forum.index'))
							  <span class="input-group-addon">
				                  <input type="checkbox" name="closed_location" checked value="{{ Route::current()->getName() }}"> This location
								  <input type="hidden" name="resource_id" value="{{ $resource_id or 0 }}"/>
		                      </span>
						  @endif
						  <span class="input-group-btn">
			      <button class="btn btn-success btn-search" type="submit"><span class="glyphicon glyphicon-search"></span> Go!</button>
			    </span>
					  </div>
				  </div>
				  {{ Form::close() }}
			  </div>
		  </div>
	</div>
		  <div class="row">
		  <div class="col-lg-12 search-bar-mobile">
			  {{ Form::open(array('url' => '/search')) }}
			  <div class="col-lg-12 pull-right">
				  <div class="input-group">
					  <input type="text" name="query" class="form-control search-text" placeholder="Search for...">
					  @if(Route::current() && Route::current()->getName() != 'index')
						  <span class="input-group-addon">
				      <input type="checkbox" name="closed_location" checked value="{{ Route::current()->getName() }}"> This location
		            </span>
					  @endif
					  <span class="input-group-btn">
			      <button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search"></span> Go!</button>
			    </span>
				  </div>
			  </div>
			  {{ Form::close() }}
		  </div>
		  </div>
	@if (Auth::check())
	<div class="row">
		  <div class="col-lg-12 user-block user-block-mobile">
		  	<a class="action-link" href="{{ URL::to('/user/settings') }}"  alt="Settings" title="Settings"><span class="glyphicon glyphicon-cog"></span></a> <a class="action-link" href="{{ URL::to('users/action/allread') }}" alt="Mark everything as read" title="Mark as Read"><span class="glyphicon glyphicon-book"></span></a> <a class="action-link" href="{{ URL::to('logout') }}" alt="Logout" title="Logout"><span class="glyphicon glyphicon-log-out"></span></a>
		  </div>
	</div>
	@endif
	<div class="row">
		{{ Breadcrumbs::addCssClasses('breadcrumb') }}
		{{ Breadcrumbs::render() }}
	</div>
		@yield('content')
    </div>

	<div class="footer">
      <div class="container">
        <p>
          <strong style="color: #ffffff;">[ <a href="//getmonero.org/legal/terms">Terms</a> | <a href="//getmonero.org/legal/privacy">Privacy</a> | <a href="//getmonero.org/legal/copyright">Copyright</a> ]</strong>
          <a href="https://getmonero.org/feed.xml"><i class="fa fa-2x fa-rss-square"></i></a>
          <a href="mailto:dev@getmonero.org"><i class="fa fa-2x fa-envelope-square"></i></a>
        </p>
      </div>
    </div>

    @yield('modals')

    <!-- JS -->
    <script src="//static.getmonero.org/js/jquery.min.js"></script>
    <script src="//static.getmonero.org/js/bootstrap.min.js"></script>
    <script src="//static.getmonero.org/js/monero.js"></script>
    <script src="/js/bootstrap-markdown.js"></script>
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
