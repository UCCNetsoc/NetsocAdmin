@foreach ($errors->all() as $message)
    <li>{{ $message }}</li>
@endforeach

{!! Form::open([
	"route" => ['manage/mysql/add'],
	"method" => "POST",
	'class' => 'row col s12'
]) !!}
<div class="row">
	<div class="input-field">
		{!! Form::label('db_name', 'Database Name') !!}
		{!! Form::text('db_name') !!}
	</div>
</div>

<button class="btn waves-effect waves-light" type="submit" name="action">Create
	<i class="mdi-content-send right"></i>
</button>
<br />
<br />
<p>All database names will be prepended with your username.</p>
{!! Form::close() !!}