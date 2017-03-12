<?php

namespace Packages\SimpleShop\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use HomeController as CoreHomeController;
use Packages\Ecommerce\Product;

class AuthController extends CoreHomeController
{
    public function login()
    {
        \Metatag::set('title', 'Đăng nhập');
        return view('Home::auth.login', $this->data);
    }

    public function register()
    {
        \Metatag::set('title', 'Đăng ký');
        return view('Home::auth.register', $this->data);
    }

    public function resetPassword()
    {
        \Metatag::set('title', 'Quên mật khẩu');
        return view('Home::auth.reset-password', $this->data);
    }
}
