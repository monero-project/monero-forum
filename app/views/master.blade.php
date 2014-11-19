<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@if(isset($title)){{ $title }}@else{{ 'Monero | Forum' }}@endif</title>

    <link href="/css/bootstrap.min.css" rel="stylesheet">
    @yield('css')
    <link href="/css/main.css" rel="stylesheet">
    <link href="/css/forum.css" rel="stylesheet">
    
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="navbar navbar-default navbar-static-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <!--
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          -->
          <a class="navbar-brand" href="/"><img src="/images/logo.svg" class="logo"></a>
        </div>
        <!--
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a class="yellow" href="#">Home</a></li>
            <li><a class="purple" href="#">Blog</a></li>
            <li><a class="red" href="#">Price Chart</a></li>
            <li><a class="orange" href="#">Getting Started</a></li>
            <li><a class="softyellow" href="#">Downloads</a></li>
            <li><a class="green" href="#">Contact</a></li>
          </ul>
        </div>
        -->
      </div>
    </div>
    <div class="container main-content">
    @if (Session::has('messages'))
	<div class="row">
		<div class="alert alert-info fade in" role="alert">
	      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
	      @foreach(Session::pull('messages') as $message)
	      <b>{{ $message }}</b>
	      @endforeach
	    </div>
	</div>
	@endif
	@if (Session::has('errors'))
	<div class="row">
		<div class="alert alert-danger fade in" role="alert">
	      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
	      @foreach(Session::pull('errors') as $error)
	      <b>{{ $error }}</b>
	      @endforeach
	    </div>
	</div>
	@endif
	<!--
	<div class="row search-bar">
        {{ Form::open(array('url' => '/search')) }}
        <div class="col-lg-6 right-float">
		    <div class="input-group">
		      <input type="text" name="query" class="form-control search-text" placeholder="What would you like to find?">
		      <span class="input-group-addon">
		        <input type="checkbox" name="closed_location"> This location
		      </span>
		      <span class="input-group-btn">
		        <button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search"></span> Go!</button>
		      </span>
		    </div>
		</div>
        {{ Form::close() }}
	</div>
	-->
	<div class="row">
	    <div class="col-lg-12 user-block">
	    @if (Auth::check())
	    	Hello, 
            <a class="name" href="{{ URL::to('/user/profile') }}">{{{ Auth::user()->username }}}</a>. <a class="action-link user-block-mobile-disable" href="{{ URL::to('/user/settings') }}"  alt="Settings" title="Settings"><span class="glyphicon glyphicon-cog"></span></a> 
            <a class="action-link user-block-mobile-disable" href="{{ URL::to('users/action/allread') }}" alt="Mark everything as read" title="Mark as Read"><span class="glyphicon glyphicon-book"></span></a> 
            <a class="action-link user-block-mobile-disable" href="{{ URL::to('logout') }}" alt="Logout" title="Logout"><span class="glyphicon glyphicon-log-out"></span></a>
	    	<br>
	    @else
	    	Please <a href="/login" class="link-disabled action-link">login</a> or <a href="/register" class="link-disabled action-link">register</a>.
	    @endif
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
          Copyright &copy; <strong>The Monero Project</strong> 
        </p>
      </div>
    </div>

    @yield('modals') 

    <!-- JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/monero.js"></script>
    @yield('javascript')
    
  </body>
</html>
@if (Auth::check())
{{ NULL; Auth::user()->touch() }}
@endif