@extends('layouts.default-with-sidebar');

@section('body-class') account-update @endsection

@section('title') Account Details @endsection

@section('content')

<h1>Account</h1>

{!! Form::open([
  "route" => ['manage/account/update'],
  "method" => "POST",
  'class' => 'row col s12'
]) !!}

<div class="row col l10">
  <ul class="collapsible" data-collapsible="accordion">
    <li>
      <div class="collapsible-header active"><i class="fa fa-user"></i>Basic Details</div>
      <div class="collapsible-body">
        <ul>
          @foreach ($errors->all() as $message)
              <li>{{ $message }}</li>
          @endforeach
        </ul>
        <br />
        <div class="row">
          <div class="input-field">
            {!! Form::label('name', 'Name') !!}
            {!! Form::text('name', $info['name']) !!}
          </div>
        </div>
        <div class="row">
          <div class="input-field col l6">
            {!! Form::label('course', 'Course') !!}
            {!! Form::text('course', $info['course']) !!}
          </div>
          <div class="input-field col l6">
            {!! Form::label('graduation_year', 'Graduation Year') !!}
            {!! Form::text('graduation_year', $info['graduation_year']) !!}
          </div>
        </div>
      </div>
    </li>
    <li>
      <div class="collapsible-header"><i class="fa fa-asterisk"></i>Password</div>
      <div class="collapsible-body">
        <div class="row">
          <div class="input-field">
            {!! Form::label('password', 'Password') !!}
            {!! Form::password('password') !!}
          </div>
          <p>Please be mindful that you may still need to use your old password to SSH into our server for the next 10 minutes. If you would like an <strong>immediate</strong> change, please SSH in and execute the "passwd" command.</p>
        </div>
      </div>
    </li>
  </ul>
  <button class="btn waves-effect waves-light" type="submit" name="action">Update Details
    <i class="mdi-content-send right"></i>
  </button>

  {{ csrf_field() }}
  {!! Form::close() !!}
</div>
@endsection