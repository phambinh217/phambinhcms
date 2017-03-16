@extends('Cms::layouts.blank')

@push('blank.css')
    <link rel="stylesheet" type="text/css" href="{{ asset_url('admin', 'pages/css/error.min.css') }}">
    <?php \Asset::where('css')->onlyCss()->render(); ?>
    @stack('css')
@endpush

@section('blank.main')
    @yield('content')
@endsection

@push('blank.html_footer')
    @stack('html_footer')
@endpush

@push('blank.js_footer')
    <?php \Asset::where('js_footer')->onlyJs()->render(); ?>
    @stack('js_footer')
@endpush