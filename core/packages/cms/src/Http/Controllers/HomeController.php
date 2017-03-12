<?php

namespace Packages\Cms\Http\Controllers;

use App\Http\Controllers\Controller;

class HomeController extends AppController
{
    public function __construct()
    {
        parent::__construct();
        
        // Gọi action khởi chạy app
        do_action('home.init');

        // Gọi action đóng app
        do_action('home.destroy');
    }
}
