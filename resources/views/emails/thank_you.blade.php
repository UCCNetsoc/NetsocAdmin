@extends('layouts.default')

@section('body-class') valign-wrapper register @endsection

@section('content')

<main class="row container">
	<section class="card-panel white col l6 offset-l3 s12 valign	">
		<img src="{{ URL::to('/') }}/images/logo.png" class="form-logo"/>

		<h3 class="center-align"> Thank you! Check your email for the confirmation code! </h3>

		<br /><br /><br />
		
	</section>

</main>

@endsection
