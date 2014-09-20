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
	<div class="row">
	    <div class="col-lg-12 user-block">
	    @if (Auth::check())
	    	Hello, <a class="name" href="{{ URL::to('/user/profile') }}">{{{ Auth::user()->username }}}</a>. <a class="action-link user-block-mobile-disable" href="{{ URL::to('/user/settings') }}"  alt="Settings" title="Settings"><span class="glyphicon glyphicon-cog"></span></a> <a class="action-link user-block-mobile-disable" href="{{ URL::to('logout') }}" alt="Logout" title="Logout"><span class="glyphicon glyphicon-log-out"></span></a>
	    	<br>
	    @else
	    	Please <a href="/login" class="link-disabled action-link">login</a> or <a href="/register" class="link-disabled action-link">register</a>.
	    @endif
	    </div>
	</div>
	@if (Auth::check())
	<div class="row">
	    <div class="col-lg-12 user-block user-block-mobile">
	    	<a class="action-link" href="{{ URL::to('/user/settings') }}"  alt="Settings" title="Settings"><span class="glyphicon glyphicon-cog"></span></a> <a class="action-link" href="{{ URL::to('logout') }}" alt="Logout" title="Logout"><span class="glyphicon glyphicon-log-out"></span></a>
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
    
    @if(!Auth::check())
    <div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModal" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	        <h4 class="modal-title" id="registerModal">Register</h4>
	      </div>
	      {{ Form::open(array('url' => 'register')) }}
	      <div class="modal-body">
            <div class="form-group">
            	<label>Username</label>
            	{{ Form::text('username', null, array('class'=>'form-control reg-username', 'placeholder'=>'')) }}
            </div>
            <div class="form-group username-alert" style="display: none;">
            	<div class="alert alert-warning alert-dismissible" role="alert">
				  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				  It looks like this username is already taken in the Web of Trust. In order to use this name, you will have to confirm your ownership of the name with the key belonging to this user.
				</div>
            </div>          
            <div class="form-group">
            	<label>Email</label>
            	{{ Form::email('email', null, array('class'=>'form-control', 'placeholder'=>'')) }}
            </div>      
            <div class="form-group">
            	<label>Password</label>
            	{{ Form::password('password', array('class'=>'form-control', 'placeholder'=>'')) }}
            </div>
            <div class="form-group">
            	<label>Confirm Password</label>
            	{{ Form::password('password_confirmation', array('class'=>'form-control', 'placeholder'=>'')) }}
            </div>
            <div class="form-group reg-key" style="display: none;">
            	<label>Key ID</label>
            	{{ Form::text('key', null, array('class'=>'form-control', 'placeholder'=>'785DEFB41BECA9ED')) }}
            </div>
            <div class="checkbox wot_register">
			    <label>
			      <input type="checkbox" name="wot_register" class="wot_register_check"> <small>(Optional)</small> Register in the Web of Trust? Requires GPG / PGP
			    </label>
			</div>
          </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	        <button type="submit" class="btn btn-success">Register</button>
	      </div>
	      {{ Form::close() }}
	    </div>
	  </div>
	</div>
	<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModal" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	        <h4 class="modal-title" id="loginModal">Login</h4>
	      </div>
	      {{ Form::open(array('url' => 'login')) }}
	      <div class="modal-body">
            <div class="form-group">
            	<label>Username</label>
            	{{ Form::text('username', null, array('class'=>'form-control', 'placeholder'=>'')) }}
            </div>     
            <div class="form-group">
            	<label>Password</label>
            	{{ Form::password('password', array('class'=>'form-control', 'placeholder'=>'')) }}
            </div>
          </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	        <button type="submit" class="btn btn-success">Login</button>
	      </div>
	      {{ Form::close() }}
	    </div>
	  </div>
	</div>
    @else
    @endif
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