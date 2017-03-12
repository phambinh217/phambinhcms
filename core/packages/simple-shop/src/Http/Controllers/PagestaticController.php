<?php

namespace Packages\SimpleShop\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use HomeController as CoreHomeController;

class PagestaticController extends CoreHomeController
{
    /**
     * Trang giới thiệu
     */
    public function about()
    {
    }

    /**
     * Trang liên hệ
     */
    public function contact()
    {
        \Metatag::set('title', 'Liên hệ');
        return view('Home::pagestatic.contact', $this->data);
    }

    public function contactSuccess()
    {
        \Metatag::set('title', 'Liên hệ thành công');
        return view('Home::pagestatic.contact-success', $this->data);
    }

    /**
     * Trang điều khoản
     */
    public function term()
    {
    }

    /**
     * Trang hỗ trợ
     */
    public function support()
    {
    }
}
