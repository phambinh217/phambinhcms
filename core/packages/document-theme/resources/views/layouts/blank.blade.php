<!DOCTYPE html>
<html lang="vi" class="no-js">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width" />
    <link rel="profile" href="http://gmpg.org/xfn/11" />
    @php \Metatag::render(); @endphp
	<script>
	    window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
            'baseUrl'   =>  url('/'),
        ]); ?>
	</script>
    <link rel="stylesheet" href="{{ asset_url('document-theme', 'css/laravel-9d78469b5d.css') }}" />
    <link rel="apple-touch-icon" href="{{ asset_url('document-theme', 'favicon.png') }}">
    <script src="{{ asset_url('document-theme', 'libs/vue/1.0.26/vue.min.js') }}"></script>
    @stack('blank.css')
</head>
<body class="{{ $body_class or 'docs language-php scotchified' }}">

	@yield('main')
	
	@stack('blank.css.html_footer')
    <script src="{{ asset_url('document-theme', 'js/laravel-58d0bb583e.js') }}"></script>
    <script src="{{ asset_url('document-theme', 'js/viewport-units-buggyfill.js') }}"></script>
    <script>window.viewportUnitsBuggyfill.init();</script>
    @stack('blank.css.js_footer')
</body>
</html>