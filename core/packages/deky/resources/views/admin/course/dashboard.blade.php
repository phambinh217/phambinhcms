@extends('Cms::layouts.default',[
    'active_admin_menu' => ['dashboard', 'overview'],
    'breadcrumbs'       =>  [
        'title' => ['Tổng quan'],
        'url'   => [
            route('admin.dashboard'),
        ],
    ],
])

@section('page_title', 'Bảng quản trị')
@section('page_sub_title', 'Tổng quan và thống kê')

@section('content')
    
@endsection

@push('css')
	
@endpush

@push('js_footer')
	
@endpush