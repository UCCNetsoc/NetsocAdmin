@extends('layouts.default-with-sidebar')


@section('content')

	<h1>Logging In</h1>
	<p class="flow-text">The first thing we’re going to need to do, is actually log you into Leela (our primary user server). To do this, we’ll use Secure Shell (SSH).</p>

	<h3>Mac OSX / Linux</h3>
	<p class="flow-text">SSH clients come preinstalled on all versions of Mac OSX and Linux. To start using it, open up your terminal/console/command prompt of some kind, and execute the following command:</p>
	
	<pre><code class="flow-text">
	ssh {{ Auth::user()->uid }}@leela.netsoc.co
	</pre></code>

	<p class="flow-text">You’ll then be prompted for your password.</p>

	<h3>Windows</h3>
	<p class="flow-text">You’ll need to install some kind of SSH client for windows. We recommend using <a href="http://www.chiark.greenend.org.uk/~sgtatham/putty/download.html">PuTTY</a>.</p>

	<p class="flow-text">To use PuTTY, we’d recommend this <a href="https://mediatemple.net/community/products/dv/204404604/using-ssh-in-putty-">tutorial</a>.</p>

	<p class="flow-text">You’ll need the following details:</p>
	
	<pre><code class="flow-text">
	hostname:   leela.netsoc.co
	username:   {{ Auth::user()->uid }}
	port:       22
	</pre></code>
@endsection