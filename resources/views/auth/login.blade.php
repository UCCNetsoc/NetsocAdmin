@extends('layouts.default')

@section('body-class') valign-wrapper login @endsection

@section('content')
	<main class="row container">
		@include('forms.login')
	</main>
@stop