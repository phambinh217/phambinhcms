@extends('Home::layouts.blank')

@section('main')
	@include('Home::partials.header')
	@yield('content')
	@include('Home::partials.footer')
@endsection