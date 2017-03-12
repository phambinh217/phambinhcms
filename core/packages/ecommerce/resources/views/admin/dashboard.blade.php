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
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 margin-bottom-10">
        <div class="dashboard-stat blue">
            <div class="visual">
                <i class="fa fa-briefcase fa-icon-medium"></i>
            </div>
            <div class="details">
                <div class="number"> $168,492.54 </div>
                <div class="desc"> Lifetime Sales </div>
            </div>
            <a class="more" href="javascript:;"> View more
                <i class="m-icon-swapright m-icon-white"></i>
            </a>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
        <div class="dashboard-stat red">
            <div class="visual">
                <i class="fa fa-shopping-cart"></i>
            </div>
            <div class="details">
                <div class="number"> 1,127,390 </div>
                <div class="desc"> Total Orders </div>
            </div>
            <a class="more" href="javascript:;"> View more
                <i class="m-icon-swapright m-icon-white"></i>
            </a>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
        <div class="dashboard-stat green">
            <div class="visual">
                <i class="fa fa-group fa-icon-medium"></i>
            </div>
            <div class="details">
                <div class="number"> $670.54 </div>
                <div class="desc"> Average Orders </div>
            </div>
            <a class="more" href="javascript:;"> View more
                <i class="m-icon-swapright m-icon-white"></i>
            </a>
        </div>
    </div>
</div>
@endsection

@push('css')
	
@endpush

@push('js_footer')
	
@endpush