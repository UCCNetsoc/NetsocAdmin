@include('layouts.header')

<div class="row with-sidebar">
	@include('layouts.sidebar')
	
	<main class="col offset-l3 l9 s12">
		@yield('content')
	</main>
</div>

@include('layouts.footer')