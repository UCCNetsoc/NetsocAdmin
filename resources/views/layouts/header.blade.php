<!DOCTYPE html>
<html>
<head>
	<title>@yield('title', env('SITE_TITLE'))</title>
	<meta charset="utf-8">
	<meta name="description" content="@yield('description')" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<link rel="shortcut icon" href="{{ URL::to('/') }}/images/favicon.png">

	
	<link rel="stylesheet" type="text/css" href="{{ URL::to('/') }}/css/font-awesome.min.css">
	<link rel="stylesheet" href="{{ URL::to('/') }}/css/normalize.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.96.1/css/materialize.min.css">
	<link rel="stylesheet" type="text/css" href="{{ URL::to('/') }}/css/app.css">
	@yield('extra-css')
	
	<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.96.1/js/materialize.min.js"></script>
	<script type="text/javascript" src="{{ URL::to('/') }}/js/main.js"></script>
	@yield('extra-js')


	@yield('extra-head')
</head>
<body>
    
    <header>
    	<nav>
			<div class="nav-wrapper container">
			  <a href="{{ URL::to('/home') }}" class="brand-logo">
			  	<figure>
					<img src="images/logo.png" alt="{{ env( 'SITE_TITLE' ) }}" class="logo">
					<figcaption class="sr-only">
						<h1> {{ env( 'SITE_TITLE' ) }}</h1>
					</figcaption>
				</figure>
			  </a>
			  <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="mdi-navigation-menu"></i></a>
			  <ul class="right hide-on-med-and-down">
			  	@if( Auth::check( ) )
			  		<li><a href="{{ URL::to( 'home' ) }}">Home</a></li>
			  	@else 
					<li class="login"><a class="waves-effect waves-light modal-trigger" href="#login-modal">Login</a></li>
					<li><a href="{{ URL::route('register') }}">Register</a></li>
			  	@endif
			  </ul>
			  <ul class="side-nav" id="mobile-demo">

			  	@if( Auth::check( ) )
			  		<li><a href="{{ URL::to( 'home' ) }}">Home</a></li>
			  	@else 
					<li class="login"><a class="waves-effect waves-light modal-trigger" href="#login-modal">Login</a></li>
					<li><a href="{{ URL::route('register') }}">Register</a></li>
			  	@endif
			 
			  </ul>
			</div>
		</nav>
	</header>