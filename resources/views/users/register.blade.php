@extends('layouts.default')

@section('content')

<main class="row container">
	<section class="card-panel white col m6 offset-m3">
		<h3 class="center-align"> Register </h3>
		@foreach ($errors->all() as $message)
	        <li>{{ $message }}</li>
	    @endforeach

		{!! Form::open([
			"route" => ['user/store'],
			"method" => "POST",
			'class' => 'row col s12'
		]) !!}
		<div class="row">
			<div class="input-field">
				{!! Form::label('email', 'Email') !!}
				{!! Form::email('email', null, ["class" => "example"] ) !!}
			</div>
		</div>
		<div class="row">
			<div class="input-field">
				{!! Form::label('username', 'Username') !!}
				{!! Form::text('username', null, ["class" => "example"] ) !!}
			</div>
		</div>
		
		<div class="row">
			<div class="input-field">
				{!! Form::label('password', 'Password') !!}
				{!! Form::password('password', null, ["class" => "example"] ) !!}
			</div>
		</div>
		<div class="row">
			<div class="input-field">
				{!! Form::label('password_confirmation', 'Confirm Password') !!}
				{!! Form::password('password_confirmation', null, ["class" => "example"] ) !!}
			</div>
		</div>
		<button class="btn waves-effect waves-light" type="submit" name="action">Register
			<i class="mdi-content-send right"></i>
		</button>
		{!! Form::close() !!}

		<br /> 
	</section>

</main>

@endsection
