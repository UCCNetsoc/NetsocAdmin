@foreach ($errors->all() as $message)
    <li>{{ $message }}</li>
@endforeach

{!! Form::open([
	"route" => ['manage/mysql/delete'],
	"method" => "POST",
	'class' => 'row col s12'
]) !!}
<div class="row">
	<div class="input-field">
		{!! Form::label('delete_db_name', 'To Confirm delete, please type the database name') !!}
		{!! Form::text('delete_db_name') !!}
	</div>
</div>

<input type="hidden" value="" id="delete-db-name" name="delete_db_name_encrypted" />
<button class="btn waves-effect waves-light red" type="submit" name="delete">Delete <span id="the-pre-deleted-database"></span>
	<i class="mdi-content-send right"></i>
</button>
<br />
<br />

{!! Form::close() !!}