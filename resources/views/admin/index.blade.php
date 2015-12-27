@extends('layouts.default-with-sidebar')

@section('content')
	<h1>Home</h1>
	
	<div class="row">
		{{-- MySQL Card --}}
		<a href="{{ URL::route('manage/mysql') }}" class="col l4 s12">
			<div class="card hoverable card-horizontal valign-wrapper">
				<div class="card-image center-align teal">
					<span class="fa-stack fa-4x">
						<i class="fa fa-database fa-stack-2x"></i>
						<i class="fa fa-cogs fa-stack-1x fa-inverse"></i>
					</span>
				</div>
				<div class="card-content">
					<div class="card-title center-align valign">MySQL Databases</div>
				</div>
				{{-- <div class="card-action">
					<a href="#"><i class="mdi-social-share"></i></a>
					<a href="#"><i class="mdi-action-favorite-outline"></i></a>
				</div> --}}
			</div>
		</a>
		
		{{-- Domains --}}
		<a href="#!" class="col l4 s12">
			<div class="card hoverable card-horizontal valign-wrapper disabled">
				<div class="card-image center-align red lighten-1">
					<span class="fa-stack fa-4x">
						<i class="fa fa-globe fa-stack-2x"></i>
						<i class="fa fa-sitemap fa-stack-1x fa-inverse"></i>
					</span>
				</div>
				<div class="card-content">
					<div class="card-title center-align valign">Domains</div>
					<small class="center-align col s12">(Coming Soon)</small>
				</div>
				{{-- <div class="card-action">
					<a href="#"><i class="mdi-social-share"></i></a>
					<a href="#"><i class="mdi-action-favorite-outline"></i></a>
				</div> --}}
			</div>
		</a>
		
		{{-- Account --}}
		<a href="{{ URL::route('manage/account') }}" class="col l4 s12">
			<div class="card hoverable card-horizontal valign-wrapper">
				<div class="card-image center-align orange lighten-2">
					<img src="https://robohash.org/{{ Auth::user()->uid }}" />
				</div>
				<div class="card-content">
					<div class="card-title center-align valign">Account</div>
				</div>
				{{-- <div class="card-action">
					<a href="#"><i class="mdi-social-share"></i></a>
					<a href="#"><i class="mdi-action-favorite-outline"></i></a>
				</div> --}}
			</div>
		</a>
	</div>

	<div class="row">
		{{-- Wordpress --}}
		<a href="{{ URL::route('manage/wordpress') }}" class="col l4 s12">
			<div class="card hoverable card-horizontal valign-wrapper">
				<div class="card-image center-align wordpress">
					<span class="fa-stack fa-4x">
						<i class="fa fa-wordpress fa-stack-2x white-text"></i>
					</span>
				</div>
				<div class="card-content">
					<div class="card-title center-align valign">Install Wordpress</div>
				</div>
				{{-- <div class="card-action">
					<a href="#"><i class="mdi-social-share"></i></a>
					<a href="#"><i class="mdi-action-favorite-outline"></i></a>
				</div> --}}
			</div>
		</a>
		
		
		{{-- Materialize --}}
		<a href="{{ URL::route('manage/mysql') }}" class="col l4 s12">
			<div class="card hoverable card-horizontal valign-wrapper">
				<div class="card-image center-align blue lighten-2">
					<span class="fa-stack fa-4x">
						<i class="fa fa-square fa-stack-2x"></i>
						<i class="fa fa-code fa-stack-1x fa-inverse"></i>
					</span>
				</div>
				<div class="card-content">
					<div class="card-title center-align valign">Materialize Framework</div>
				</div>
				{{-- <div class="card-action">
					<a href="#"><i class="mdi-social-share"></i></a>
					<a href="#"><i class="mdi-action-favorite-outline"></i></a>
				</div> --}}
			</div>
		</a>
		
		{{-- Account --}}
		<a href="{{ URL::route('manage/mysql') }}" class="col l4 s12">
			<div class="card hoverable card-horizontal valign-wrapper">
				<div class="card-image center-align light-green lighten-1">
					<span class="fa-stack fa-4x">
						<i class="fa fa-circle fa-stack-2x fa-inverse"></i>
						<i class="fa fa-fire-extinguisher fa-stack-1x "></i>
					</span>
				</div>
				<div class="card-content">
					<div class="card-title center-align valign">Backups</div>
				</div>
				{{-- <div class="card-action">
					<a href="#"><i class="mdi-social-share"></i></a>
					<a href="#"><i class="mdi-action-favorite-outline"></i></a>
				</div> --}}
			</div>
		</a>
	</div>

	<div class="row">
		{{-- Wordpress --}}
		<a href="{{ URL::route('manage/mysql') }}" class="col l4 s12">
			<div class="card hoverable card-horizontal valign-wrapper">
				<div class="card-image center-align amber">
					<span class="fa-stack fa-4x">
						<i class="fa fa-square fa-stack-2x"></i>
						<i class="fa fa-terminal fa-stack-1x fa-inverse"></i>
					</span>
					</span>
				</div>
				<div class="card-content">
					<div class="card-title center-align valign">How To SSH</div>
				</div>
				{{-- <div class="card-action">
					<a href="#"><i class="mdi-social-share"></i></a>
					<a href="#"><i class="mdi-action-favorite-outline"></i></a>
				</div> --}}
			</div>
		</a>
		
		
		<a href="{{ URL::route('manage/mysql') }}" class="col l4 s12">
			<div class="card hoverable card-horizontal valign-wrapper">
				<div class="card-image center-align  lime">
					<span class="fa-stack fa-4x">
						<i class="fa fa-desktop fa-stack-2x"></i>
						<i class="fa fa-comments fa-stack-1x fa-1x fa-inverse"></i>
					</span>
					</span>
				</div>
				<div class="card-content">
					<div class="card-title center-align valign">How To IRC</div>
				</div>
				{{-- <div class="card-action">
					<a href="#"><i class="mdi-social-share"></i></a>
					<a href="#"><i class="mdi-action-favorite-outline"></i></a>
				</div> --}}
			</div>
		</a>

	</div>
@endsection