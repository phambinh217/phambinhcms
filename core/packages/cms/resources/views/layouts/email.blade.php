<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

    <style type="text/css" rel="stylesheet" media="all">
        /* Media Queries */
        @media only screen and (max-width: 500px) {
            .button {
                width: 100% !important;
            }
        }
    </style>
</head>

<body style="{{ config('email-style.body') }}">
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td style="{{ config('email-style.email-wrapper') }}" align="center">
                <table width="100%" cellpadding="0" cellspacing="0">
                    <!-- Logo -->
                    <tr>
                        <td style="{{ config('email-style.email-masthead') }}">
                            @yield('header')
                        </td>
                    </tr>

                    <!-- Email Body -->
                    <tr>
                        <td style="{{ config('email-style.email-body') }}" width="100%">
                            <table style="{{ config('email-style.email-body_inner') }}" align="center" width="570" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="{{ config('email-style.font-family') }} {{ config('email-style.email-body_cell') }}">
                                        @yield('main')
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td>
                            <table style="{{ config('email-style.email-footer') }}" align="center" width="570" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="{{ config('email-style.font-family') }} {{ config('email-style.email-footer_cell') }}">
                                        @yield('footer')
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
