<?php

namespace Packages\SimpleShop\Http\Controllers;

use Illuminate\Http\Request;
use HomeController as CoreHomeController;
use Packages\Ecommerce\Product;

class HomeController extends CoreHomeController
{
    public function index()
    {
        \Metatag::set('titel', 'Trang chủ');
        return view('Home::home', $this->data);
    }

    public function search(Request $request)
    {
        $filter = Product::getRequestFilter();
        $products = Product::select('products.*')->applyFilter($filter)->paginate(config('baseshop.paginate'));
        $this->data['products'] = $products;
        $this->data['filter'] = $filter;
        
        \Metatag::set('title', 'Tìm kiếm');

        return view('Home::search', $this->data);
    }
}
