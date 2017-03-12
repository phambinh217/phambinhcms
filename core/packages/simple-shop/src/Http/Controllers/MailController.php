<?php

namespace Packages\SimpleShop\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use HomeController as CoreHomeController;

class MailController extends CoreHomeController
{
    public function __construct()
    {
        $this->middleware('auth');
        parent::__construct();
    }

    public function index()
    {
        \Metatag::set('title', 'Hộp thư');
        return view('Home::mail.index', $this->data);
    }
}
