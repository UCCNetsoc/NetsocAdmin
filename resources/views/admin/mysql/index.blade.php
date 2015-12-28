@extends('layouts.default-with-sidebar')


@section('content')
	
	<h1>MySQL Databases</h1>
	
	<div class="row">
	<div class="col s12 m8 offset-m2 l6 offset-l1">
		<div class="card-panel grey lighten-5 z-depth-1">
			<div class="row valign-wrapper">
				<div class="col s4">
				  <img src="https://robohash.org/{{ Auth::user()->uid }}" alt="" class="circle responsive-img teal">
				</div>
				<div class="col s8">
					<span class="mysql-details">
						<ul class="fa-ul">
							<li><i class="fa-li fa fa-user"></i>Username: <strong>{{ Auth::user()->uid }}</strong></li>
							<li>
								<i class="fa-li fa fa-asterisk"></i>
								Password: <strong id="password-reveal">******</strong>  
								<div class="progress hide" id="password-progress">
								    <div class="indeterminate"></div>
								</div>
  								<a class="waves-effect waves-light btn modal-trigger" href="#passwordReveal" >Show DB Password</a></li>
						</ul>
					</span>
					<span class="center-align col s12">
						<a href="{{ App\Setting::where('name', 'db_manager_url')->first()->setting }}">Manage Databases &nbsp;<i class="fa fa-external-link"></i></a>
					</span>
				</div>
			</div>
		</div>
	</div>
			
	</div>
	
	<div class="row col l8">
		<div class="right-align">
			<a class="waves-effect waves-light btn modal-trigger" href="#create-database">Create New Database</a>
		</div>
		<table class="striped">
			<thead>
			  <tr>
				  <th data-field="id">Name</th>
				  <th data-field="id">Size</th>
				  <th data-field="name" class="center-align">Delete</th>
			  </tr>
			</thead>

			<tbody>
			  @foreach( $databases as $database )
				<tr>
					<td>{{ $database->db_name }}</td>
					<td>
						{{ $database->size }}MB
					</td>
					<td class="center-align">  
						<a class="btn-floating btn-medium waves-effect waves-light red" onclick="confirmDeletion('{{$database->db_name}}', '{{ Crypt::encrypt( $database->db_name ) }}');"><i class="fa fa-trash"></i></a>
					</td>
				</tr>
			  @endforeach
			</tbody>
		</table>
	</div>


	<!-- Modal Structure -->
	<div id="passwordReveal" class="modal bottom-sheet">
		<div class="modal-content">
			<h4>Please Enter Your Netsoc Account Password</h4>
			<input type="password" id="password-input" placeholder="password"/>
		</div>
		<div class="modal-footer">
			<a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat" onclick="revealPassword( '{{ Crypt::encrypt( Auth::user()->uid ) }}', '{{ URL::to("/") }}')">Show Me My Database Password</a>
		</div>
	</div>

	<div id="create-database" class="modal">
		<div class="modal-content">
			<h4>Create A Database</h4>
			@include('admin.mysql.form_add-database')
		</div>
		<div class="modal-footer">
			<a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Cancel</a>
		</div>
	</div>

	<div id="delete-database" class="modal bottom-sheet">
		<div class="modal-content">
			@include('admin.mysql.form_delete-database')
		</div>
		<div class="modal-footer">
			<a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Cancel</a>
		</div>
	</div>
		  

	<meta name="_token" content="{{ csrf_token() }}">
@endsection