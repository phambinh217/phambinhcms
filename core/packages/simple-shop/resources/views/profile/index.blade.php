@extends('Home::layouts.default')

@section('content')
	<div class="ui container">
		<div class="ui massive breadcrumb">
			<a class="section" href="{{ url('/') }}">Trang chủ</a>
			<i class="right chevron icon divider"></i>
			<a class="section active">Trang cá nhân</a>
		</div>
		<h1 class="ui header">
			{{ \Auth::user()->full_name }}
		</h1>
		<div class="ui grid">
			<div class="four wide column">
				@include('Home::partials.sidebar-profile')
			</div>
			<div class="twelve wide column">
				
			</div>
		</div>
	</div>
@endsection