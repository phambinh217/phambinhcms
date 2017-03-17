@extends('Cms::layouts.default',[
	'active_admin_menu' 	=> ['file'],
	'breadcrumbs' 			=> [
		'title'	=> [trans('file.manage-file')],
		'url'	=> [],
	],
])

@section('page_title', trans('file.manage-file'))

@section('content')
	<div class="embed-responsive embed-responsive-16by9">
		<iframe class="embed-responsive-item" src="{{ route('admin.file.stand-alone') }}"></iframe>
	</div>
@endsection
