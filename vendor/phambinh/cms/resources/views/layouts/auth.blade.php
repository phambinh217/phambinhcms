<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js') }}"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js') }}"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<head>
        <meta charset="utf-8" />
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta name="_token" content="{{ csrf_token() }}">
        <?php \Metatag::render(); ?>
        <script>
            window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),
                'baseUrl'   =>  url('/'),
            ]); ?>
        </script>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="" name="author" />
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&amp;subset=all" rel="stylesheet" type="text/css" />
        <link href="{{ asset_url('admin', 'global/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset_url('admin', 'global/plugins/simple-line-icons/simple-line-icons.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset_url('admin', 'global/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset_url('admin', 'global/plugins/bootstrap-switch/css/bootstrap-switch.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset_url('admin', 'global/css/components.min.css') }}" rel="stylesheet" id="style_components" type="text/css" />
        <link href="{{ asset_url('admin', 'global/css/plugins.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset_url('admin', 'pages/css/login-3.min.css') }}" rel="stylesheet" type="text/css" />
        <link rel="shortcut icon" href="{{ url('favicon.ico') }} " />
    </head>

    <body class=" login">
        <div class="logo">
            <a href="{{ url('/') }}">
                <img src="{{ setting('logo', url('logo.png')) }}" alt="" style="width: 200px" />
            </a>
        </div>
        <div class="content">
            @yield( 'content')
        </div>
        <div style="padding: 30px"></div>
        <!--[if lt IE 9]>
        <script src="{{ asset_url('admin', 'global/plugins/respond.min.js') }}"></script>
        <script src="{{ asset_url('admin', 'global/plugins/excanvas.min.js') }}"></script> 
        <script src="{{ asset_url('admin', 'global/plugins/ie8.fix.min.js') }}"></script> 
        <![endif]-->
        <script src="{{ asset_url('admin', 'global/plugins/jquery.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset_url('admin', 'global/plugins/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
</body>
</html>