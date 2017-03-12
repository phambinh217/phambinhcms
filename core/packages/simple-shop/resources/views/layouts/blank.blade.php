<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	@php \Metatag::render(); @endphp
	<script>
	    window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
            'baseUrl'   =>  url('/'),
        ]); ?>
	</script>
	<link rel="stylesheet" type="text/css" href="{{ asset_url('baseshop', 'semantic/semantic.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset_url('baseshop', 'app/vendors/toastr/toastr.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset_url('baseshop', 'app/vendors/jquery-loading/loading.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset_url('baseshop', 'app/vendors/jgrowl/jquery.jgrowl.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset_url('baseshop', 'app/vendors/owlcarousel/css/owl.carousel.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset_url('baseshop', 'app/vendors/owlcarousel/css/owl.theme.default.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset_url('baseshop', 'app/css/style.css?v=1.0-beta') }}">
	@stack('css')
</head>
<body class="{{ $body_class or '' }}">
	
	@yield('main')

	@stack('html_footer')
	<script type="text/javascript" src="{{ asset_url('baseshop', 'app/vendors/jquery.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset_url('baseshop', 'semantic/semantic.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset_url('baseshop', 'app/vendors/jquery-loading/loading.js') }}"></script>
    <script type="text/javascript" src="{{ asset_url('baseshop', 'app/vendors/jquery.fajax/jquery.fajax.js') }}"></script>
    <script type="text/javascript" src="{{ asset_url('baseshop', 'app/vendors/toastr/toastr.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset_url('baseshop', 'app/vendors/jgrowl/jquery.jgrowl.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset_url('baseshop', 'app/vendors/owlcarousel/js/owl.carousel.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset_url('baseshop', 'app/vendors/jquery.zoom/jquery.zoom.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset_url('baseshop', 'app/js/app.js?v=1.0-beta') }}"></script>
	@stack('js_footer')
</body>
</html>