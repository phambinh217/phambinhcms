<?php

namespace Phambinh\Cms\Http\Controllers;

use App\Http\Controllers\Controller;

class AppController extends Controller
{
    /**
     * Biến lưu chuyển dữ liệu
     * @var array
     */
    protected $data = [];

    public function __construct()
    {
        \Metatag::set('title', setting('company-name'));
        \Metatag::set('_base_url', url('/'));

        \App::setLocale(setting('language', config('app.locale')));

        do_action('app.init');
        do_action('app.destroy');
    }
}
