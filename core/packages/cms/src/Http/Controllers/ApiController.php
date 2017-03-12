<?php

namespace Packages\Cms\Http\Controllers;

class ApiController extends AppController
{
    public function __construct()
    {
        // Gọi action khởi chạy app
        do_action('api.init');

        // Gọi action đóng app
        do_action('api.destroy');
    }
}
