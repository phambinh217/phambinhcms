@extends('Cms::layouts.blank')

@push('blank.css')
    <?php \Asset::where('css')->onlyCss()->render(); ?>
    @stack('css')
@endpush

@section('blank.main')
    <div class="page-header navbar navbar-fixed-top">
        <div class="page-header-inner ">
            <div class="page-logo">
                <a href="{{ url('/') }}">
                    <img src="{{ setting('logo', url('logo.png')) }}" alt="logo" class="logo-default" /> </a>
                <div class="menu-toggler sidebar-toggler">
                </div>
            </div>
            <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"> </a>
            @include('Cms::section.page-action')
            <div class="page-top hidden-xs">
                @include('Cms::section.top-navgation-menu')
            </div>
        </div>
    </div>
    <div class="clearfix"> </div>
    <div class="page-container">
        <div class="page-sidebar-wrapper">
            <div class="page-sidebar navbar-collapse collapse">
                @include('Cms::section.sidebar-menu', [
                    'active_admin_menu'   =>  isset($active_admin_menu) ? $active_admin_menu : [],
                ])
            </div>
        </div>
        <div class="page-content-wrapper">
            <div class="page-content">
                @if($__env->yieldContent('page_title'))
                    <div class="page-head">
                        <div class="page-title">
                            <h1>@yield('page_title')
                                @if($__env->yieldContent('page_sub_title'))
                                 <small>@yield('page_sub_title')</small>
                                @endif
                            </h1>
                        </div>
                        <div class="page-toolbar">
                            @include('Cms::section.theme-panel')
                            @if($__env->yieldContent('tool_bar'))
                                @yield('tool_bar')
                            @endif
                        </div>
                    </div>
                @endif
                @include('Cms::section.breadcrumb', [
                    'breadcrumbs' => isset($breadcrumbs) ? $breadcrumbs : [],
                ])
                @yield('content')
            </div>
        </div>
    </div>
    <div class="page-footer">
        <div class="page-footer-inner"> 2016 - {{ date('Y') }} &copy; Phambinhcms
            <a href="http://phambinh.net"" target="_blank">Phambinh.net</a>
        </div>
        <div class="scroll-to-top">
            <i class="icon-arrow-up"></i>
        </div>
    </div>
@endsection

@push('blank.html_footer')
    @stack('html_footer')
@endpush

@push('blank.js_footer')
    <?php \Asset::where('js_footer')->onlyJs()->render(); ?>
    @stack('js_footer')
@endpush