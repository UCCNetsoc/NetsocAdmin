@extends('layouts.default-with-sidebar')

@section('title') Backups @endsection

@section('content')
<h1> Backups </h1>
<div class="row">
	<div class="col s12 l6">

		<ul class="collection">
			<li class="collection-item collection-header"><h4>Weekly</h4></li>
			@foreach( $weekly_files as $file )
				<li class="collection-item avatar">
					<i class="fa fa-folder circle"></i>
					<span class="title">{{ date('l jS \of F Y', strtotime(str_replace('.tgz', '', $file))) }} </span>
					<a href="{{ URL::route('manage/backups/download', ['timeframe' => 'weekly', 'filename' => $file ]) }}" class="secondary-content"><i class="fa fa-download"></i></a>
				</li>
			@endforeach
		</ul>
	</div>

	<div class="col s12 l6">
		<ul class="collection">
			<li class="collection-item collection-header"><h4>Monthly</h4></li>
			@foreach( $monthly_files as $file )
				<li class="collection-item avatar">
					<i class="fa fa-folder circle"></i>
					<span class="title">{{ date('F', strtotime(str_replace('.tgz', '', $file))) }} </span>
					<a href="{{ URL::route('manage/backups/download', ['timeframe' => 'monthly', 'filename' => $file ]) }}" class="secondary-content"><i class="fa fa-download"></i></a>
				</li>
			@endforeach
		</ul>
	</div>
</div>
@endsection