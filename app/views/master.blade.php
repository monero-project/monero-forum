<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@if(isset($title)){{ $title }}@else{{ 'Monero | Forum' }}@endif</title>

    <link href="//static.monero.cc/css/bootstrap.min.css" rel="stylesheet">
    @yield('css')
    <link href="//static.monero.cc/css/main.css" rel="stylesheet">
    <link href="//static.monero.cc/css/forum.css" rel="stylesheet">
    
    <!--[if lt IE 9]>
      <script src="//static.monero.cc/js/html5shiv.js"></script>
      <script src="//static.monero.cc/js/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="navbar navbar-default navbar-static-top" role="navigation">
      <div class="navbar-wrapper">
        <div class="navbar-header">
          <a class="navbar-brand" href="/"><img src="//static.monero.cc/images/logo.svg" class="logo"></a>
        </div>
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
            <a class="name" href="{{ URL::to('/user/profile') }}">{{{ Auth::user()->username }}}</a>. <a class="action-link user-block-mobile-disable" href="{{ URL::to('/user/settings') }}"  alt="Settings" title="Settings"><span class="glyphicon glyphicon-cog" data-toggle="tooltip" data-placement="bottom" data-original-title="Settings"></span></a> 
            <a class="action-link user-block-mobile-disable" href="{{ URL::to('users/action/allread') }}" alt="Mark everything as read" title="Mark as Read" data-toggle="tooltip" data-placement="bottom" data-original-title="Mark forum as read"><span class="glyphicon glyphicon-book"></span></a> 
            <a class="action-link user-block-mobile-disable" href="{{ URL::to('logout') }}" alt="Logout" title="Logout"><span class="glyphicon glyphicon-log-out" data-toggle="tooltip" data-placement="bottom" data-original-title="Log Out"></span></a>
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
    <script src="//static.monero.cc/js/jquery.min.js"></script>
    <script src="//static.monero.cc/js/bootstrap.min.js"></script>
    <script src="//static.monero.cc/js/monero.js"></script>
    @yield('javascript')
    
  </body>
</html>
@if (Auth::check())
{{ NULL; Auth::user()->touch() }}
@endif
