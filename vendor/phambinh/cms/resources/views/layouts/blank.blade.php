<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta name="_token" content="{{ csrf_token() }}">
        <?php \Metatag::render(); ?>
        <script>
            window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),
                'baseUrl'   =>  url('/'),
            ]); ?>
        </script>
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&amp;subset=all" rel="stylesheet" type="text/css" />
        <link href="{{ asset_url('admin', 'global/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset_url('admin', 'global/plugins/simple-line-icons/simple-line-icons.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset_url('admin', 'global/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset_url('admin', 'global/plugins/uniform/css/uniform.default.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset_url('admin', 'global/plugins/bootstrap-switch/css/bootstrap-switch.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset_url('admin', 'global/plugins/animate/animate.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset_url('admin', 'global/css/components-md.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset_url('admin', 'global/css/plugins-md.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset_url('admin', 'layouts/layout4/css/layout.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset_url('admin', 'layouts/layout4/css/custom.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset_url('admin', 'layouts/layout4/css/themes/green.css') }}" rel="stylesheet" type="text/css" />
        <link rel="shortcut icon" href="{{ url('favicon.ico') }}" />
        @stack('blank.css')
    </head>
    <body class="{{ $body_class or 'page-container-bg-solid page-header-fixed page-sidebar-closed-hide-logo page-md' }}">
        @yield('blank.main')
        @stack('blank.html_footer')
        <!--[if lt IE 9]>
        <script src="{{ asset_url('admin', 'global/plugins/respond.min.js') }}"></script>
        <script src="{{ asset_url('admin', 'global/plugins/excanvas.min.js') }}"></script>
        <script src="{{ asset_url('admin', 'global/plugins/ie8.fix.min.js') }}"></script>
        <![endif]-->
        <script src="{{ asset_url('admin', 'global/plugins/jquery.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset_url('admin', 'global/plugins/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset_url('admin', 'global/plugins/js.cookie.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset_url('admin', 'global/plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset_url('admin', 'global/plugins/jquery.blockui.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset_url('admin', 'global/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset_url('admin', 'global/scripts/app.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset_url('admin', 'global/scripts/handle.js') }}" type="text/javascript"></script>
        <script src="{{ asset_url('admin', 'layouts/layout4/scripts/layout.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset_url('admin', 'layouts/layout4/scripts/demo.min.js') }}" type="text/javascript"></script>
        @stack('blank.js_footer')
</body>
</html>
