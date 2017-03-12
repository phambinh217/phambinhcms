<?php

namespace Packages\DocumentTheme\Http\Controllers;

use Illuminate\Http\Request;
use AppController;

class HomeController extends AppController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        return view('DocumentTheme::index', $this->data);
    }
}
