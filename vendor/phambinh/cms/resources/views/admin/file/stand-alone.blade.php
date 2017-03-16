<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ setting('company-name') }}</title>

    <link rel="stylesheet" href="{{ asset_url('admin', 'global/plugins/jquery-ui/jquery-ui.min.css') }}"/>

    <!-- elFinder CSS (REQUIRED) -->
    <link rel="stylesheet" type="text/css" href="{{ asset_url('admin', 'global/plugins/elfinder/css/elfinder.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset_url('admin', 'global/plugins/elfinder/css/theme.css') }}">
    <style>
        body {
            padding: 0 !important;
            margin : 0 !important;
        }
        .embed-responsive-16by9 {
            padding-bottom : 56.25% !important;
        }

        .embed-responsive {
            position : relative;
            display  : block;
            height   : 0;
            padding  : 0;
        }

        .embed-responsive .embed-responsive-item,
        .embed-responsive embed,
        .embed-responsive iframe,
        .embed-responsive object,
        .embed-responsive video {
            position : absolute;
            top      : 0;
            left     : 0;
            bottom   : 0;
            height   : 100% !important;
            width    : 100% !important;
            border   : 0;
        }
        .phpdebugbar {
            display : none !important;
        }
    </style>
</head>
<body>
<!-- Element where elFinder will be created (REQUIRED) -->
<div class="embed-responsive embed-responsive-16by9">
    <div id="elfinder" class="embed-responsive-item"></div>
</div>

<!-- jQuery and jQuery UI (REQUIRED) -->
<script src="{{ asset_url('admin', 'global/plugins/jquery.min.js') }}"></script>
<script src="{{ asset_url('admin', 'global/plugins/jquery-ui/jquery-ui.min.js') }}"></script>

<!-- elFinder JS (REQUIRED) -->
<script src="{{ asset_url('admin', 'global/plugins/elfinder/js/elfinder.min.js') }}"></script>

<script type="text/javascript" charset="utf-8">
    $(document).ready(function () {
        var FileBrowserDialogueTinyMCE = {
            init: function() {
              // Here goes your code for setting your custom things onLoad.
            },
            mySubmit: function (URL) {
              // pass selected file path to TinyMCE
              top.tinymce.activeEditor.windowManager.getParams().setUrl(URL);

              // close popup window
              top.tinymce.activeEditor.windowManager.close();
            }
        };
        $('#elfinder').elfinder({
            // set your elFinder options here
            customData: {
                _token: '{{ csrf_token() }}'
            },
            soundPath: '{{ asset_url('admin', 'global/plugins/elfinder/sounds') }}',
            url: '{{ admin_url('file/elfinder/connector') }}',
            resizable: false,
            getFileCallback: function(file) { // editor callback
                $fileBrowser = window.parent.document.fileBrowser;
                var from = 'tinymce';
                if($fileBrowser) {
                    from = $fileBrowser.from;
                }
                switch(from) {
                    case 'popup':
                        $fileBrowser.container.find('.file-input').val(file.url);
                        $fileBrowser.container.find('.image-preview').attr('src',file.url);
                        $fileBrowser.close();
                    break;

                    default:
                        FileBrowserDialogueTinyMCE.mySubmit(file.url); // pass selected file path to TinyMCE 
                        break;
                }
            }
        }).elfinder('instance');
    });
</script>
</body>
</html>
