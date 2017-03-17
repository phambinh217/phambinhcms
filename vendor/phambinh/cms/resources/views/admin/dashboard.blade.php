@extends('Cms::layouts.default',[
    'active_admin_menu' => ['dashboard', 'overview'],
    'breadcrumbs'       =>  [
        'title' => [trans('cms.overview')],
        'url'   => [
            route('admin.dashboard'),
        ],
    ],
])

@section('page_title', trans('cms.dashboard'))
@section('page_sub_title', trans('cms.overview-and-statistic'))

@section('content')
	
@endsection

@push('css')
	
@endpush

@push('js_footer')
	
@endpush