<?php

namespace Packages\SimpleShop\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use Packages\Ecommerce\Product;
use Packages\Ecommerce\Currency;
use Packages\Ecommerce\Option;
use Packages\Ecommerce\OptionValue;
use Packages\Ecommerce\Order;
use Packages\Ecommerce\OrderDetail;
use Packages\Ecommerce\Support\Traits\CheckoutController as ShopCheckoutController;
use HomeController as CoreHomeController;

class CheckoutController extends CoreHomeController
{
    use ShopCheckoutController;

    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
    }
    
    public function index()
    {
        \Metatag::set('title', 'Thanh toán');
        return view('Home::checkout.index', $this->data);
    }

    public function success()
    {
        \Metatag::set('title', 'Thanh toán thành công');
        return view('Home::checkout.success', $this->data);
    }

    protected function responseStore(Request $request, Order $order)
    {
        if ($request->ajax()) {
            return response()->json([
                'title' => 'Đơn hàng đã được gửi',
                'message' => 'Đơn hàng đã được gửi đến chúng tôi',
            ]);
        }

        return redirect()->back()->with('message-success', 'Đơn hàng đã được gửi');
    }

    protected function viewConfirmSuccess(Request $request, Order $order)
    {
        \Metatag::set('title', 'Xác nhận thành công');
        return view('Home::checkout.confirm.success', $this->data);
    }

    protected function viewConfirmError(Request $request, Order $order)
    {
        \Metatag::set('title', 'Xác nhận thất bại');
        return view('Home::checkout.confirm.error', $this->data);
    }
}
