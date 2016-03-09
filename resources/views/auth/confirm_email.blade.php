@extends('layouts.default')

@section('body-class') valign-wrapper register @endsection

@section('content')

<main class="row container">
	<section class="card-panel white col l6 offset-l3 s12 valign	">
		<img src="{{ URL::to('/images/logo.png') }}" class="form-logo"/>

		<h3 class="center-align"> Enter Your Student Email </h3>
		@foreach ($errors->all() as $message)
	        <li>{{ $message }}</li>
	    @endforeach

		{!! Form::open([
			"route" => ['user/sendconfirmation'],
			"method" => "POST",
			'class' => 'row col s12'
		]) !!}

		<div class="row">
			<div class="input-field">
				{!! Form::label('email', 'Student Email') !!}
				{!! Form::text('email', null, ["autofocus"] ) !!}
			</div>
		</div>
		
		<button class="btn waves-effect waves-light" type="submit" name="action">Send Verification
			<i class="mdi-content-send right"></i>
		</button>
		{!! Form::close() !!}

		<br /> 
	</section>

</main>

@endsection
