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
                    <img src="{{ url('logo.png') }}" alt="logo" class="logo-default" /> </a>
                <div class="menu-toggler sidebar-toggler">
                </div>
            </div>
            <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"> </a>
        </div>
    </div>
    <div class="clearfix"> </div>
    <div class="page-container">
        <div class="page-content-wrapper">
            <div class="page-content">
                <div class="row">
                    <div class="col-sm-10">
                        @yield('content')
                    </div>
                </div>
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