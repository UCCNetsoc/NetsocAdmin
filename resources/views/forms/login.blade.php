<section class="card-panel white col l6 offset-l3 s12 valign	">
	<img src="{{ URL::to('/') }}/images/logo.png" class="form-logo"/>

	<h3 class="center-align"> Login </h3>
	@foreach ($errors->all() as $message)
        <li>{{ $message }}</li>
    @endforeach

	{!! Form::open([
		"route" => 'user/login',
		"method" => "POST",
		'class' => 'row col s12'
	]) !!}

	<div class="row">
		<div class="input-field">
			{!! Form::label('uid', 'Username (lowercase-only)') !!}
			{!! Form::text('uid', null, ["class" => "example"] ) !!}
		</div>
	</div>
	
	<div class="row">
		<div class="input-field">
			{!! Form::label('password', 'Password') !!}
			{!! Form::password('password', null, ["class" => "example"] ) !!}
		</div>
	</div>
	
	<button class="btn waves-effect waves-light s12" type="submit" name="action">Login
		<i class="mdi-content-send right"></i>
	</button>
	
	<a href="{{ URL::route('register') }}">
		<button class="btn waves-effect waves-light s12 red lighten-2" type="button">Register
			<i class="fa fa-plus"></i>
		</button>
	</a>
	{!! Form::close() !!}

	<br /> 
</section>