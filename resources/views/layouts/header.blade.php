<!DOCTYPE html>
<html>
<head>
	<title>@yield('title', env('SITE_TITLE'))</title>
	<meta charset="utf-8">
	<meta name="description" content="@yield('description')" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<link rel="shortcut icon" href="{{ URL::to('/') }}/images/favicon.png">

	
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="{{ URL::to('/') }}/css/normalize.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.5/css/materialize.min.css">
	<link rel="stylesheet" type="text/css" href="{{ URL::to('/') }}/css/app.css">
	@yield('extra-css')
	

	<link rel="canonical" href="https://admin.netsoc.co" />
	<meta property="og:title" content="UCC Netsoc Admin" />
	<meta property="og:url" content="https://admin.netsoc.co" />
	<meta property="og:image" content="https://files.netsoc.co/f/e9e0bee5b4/?dl=1" />
	<meta property="og:image:width" content="1200" />
	<meta property="og:image:height" content="630" />
	<meta property="og:site_name" content="UCC Netsoc Admin" />
	<meta property="fb:admins" content="1385961037" />
	<meta property="og:description" content="Manage your webspace and databases in one location." />
	<meta name="twitter:card" content="summary_large_image" />
	<meta name="twitter:site" content="@UCCNetsoc" />
	<meta name="twitter:title" content="UCC Netsoc Admin" />
	<meta name="twitter:description" content="Manage your webspace and databases in one location." />
	<meta name="twitter:image" content="https://files.netsoc.co/f/e9e0bee5b4/?dl=1" />
	<meta itemprop="image" content="https://files.netsoc.co/f/e9e0bee5b4/?dl=1" />
	<script type="application/ld+json">
	{
		"@context" : "http://schema.org",
		"@type" : "Organization",
		"name" : "UCC Netsoc",
		"url" : "https://admin.netsoc.co",
		"sameAs" : ["http://www.facebook.com/UCCNetsoc","http://www.twitter.com/UCCNetsoc","http://plus.google.com/+Netsoc"] 
	}
	</script>

	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	  ga('create', 'UA-71411325-3', 'auto');
	  ga('send', 'pageview');

	</script>

	@yield('extra-head')
</head>
<body class="@yield('body-class')">
