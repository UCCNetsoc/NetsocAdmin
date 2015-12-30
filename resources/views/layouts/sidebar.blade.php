<aside class="">
	<div class="container"><a href="#" data-activates="nav-mobile" class="button-collapse top-nav full hide-on-large-only"><i class="mdi-navigation-menu"></i></a></div>
	<ul id="nav-mobile" class="side-nav fixed">
        <li class="logo">
        	<a id="logo-container" href="{{ URL::route('home') }}" class="brand-logo">
            	<img src="{{URL::to('/')}}/images/logo.png" />
            </a>
        </li>
        <li id="home"><a href="{{URL::to('/')}}" class="waves-effect waves-red">Home</a></li>
        <li id="mysql"><a href="{{ URL::route('manage/mysql') }}" class="waves-effect waves-red">MySQL Databases</a></li>
        <li id="account"><a href="{{ URL::route('manage/account') }}" class="waves-effect waves-red">Account</a></li>
        <li id="wordpress"><a href="{{ URL::route('manage/wordpress') }}" class="waves-effect waves-red">Install Wordpress</a></li>
        <li id="backups"><a href="{{ URL::route('manage/backups') }}" class="waves-effect waves-red">Backups</a></li>
        
        <li id="ssh"><a href="{{ URL::route('static/ssh') }}" class="waves-effect waves-red">How To Login</a></li>
        <li id="irc"><a href="{{ URL::route('static/irc') }}" class="waves-effect waves-red">How To IRC</a></li>

        <li id="logout"><a href="{{ URL::route('logout') }}" class="waves-effect waves-red">Logout</a></li>
    </ul>

</aside>