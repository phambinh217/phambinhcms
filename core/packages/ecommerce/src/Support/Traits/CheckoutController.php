<?php

namespace Packages\Ecommerce\Support\Traits;

use Illuminate\Http\Request;
use Packages\Ecommerce\Product;
use Packages\Ecommerce\Order;
use Packages\Ecommerce\Currency;
use Packages\Ecommerce\OptionValue;
use Packages\Ecommerce\Option;
use Packages\Ecommerce\OrderDetail;
use Validator;

trait CheckoutController
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'checkout.first_name' => 'required',
            'checkout.last_name' => 'required',
            'checkout.phone' => 'required',
            'checkout.email' => 'required',
            'checkout.address' => 'required',
            'checkout.comment' => 'max:300',
        ]);

        // Base
        $order = new Order();
        $order->fill($request->checkout);
        $order->customer_id = \Auth::user()->id;
        $order->total = \Cart::total();

        // Currency
        $currency = Currency::findOrFail(setting('default-currency-id'));
        $order->currency_id = $currency->id;
        $order->currency_code = $currency->code;
        $order->currency_value = $currency->value;
        $confirm_token = encrypt(str_random());

        if (setting('confirm-order')) {
            $order->confirm_token = $confirm_token;
            $order->status_id = setting('order-status-not-confirm');
        } else {
            $order->status_id = setting('default-order-status-id');
        }
        
        // Lưu đơn hàng
        $order->save();

        // Chi tiết đơn hàng
        $order->details()->saveMany([
            new OrderDetail(['code' => 'sub-total', 'name' => 'Tổng phụ', 'value' => \Cart::subtotal()]),
            // new OrderDetail(['code' => 'tax', 'name' => 'Thuế VAT('. config('cart.tat') .' %)', 'value' => \Cart::tax()]),
            new OrderDetail(['code' => 'total', 'name' => 'Tổng', 'value' => \Cart::total()]),
        ]);

        // Sản phẩm trong đơn hàng
        $products = Product::select('id', 'price', 'name', 'code')->whereIn('id', \Cart::content()->pluck('id'))->get();
        foreach (\Cart::content() as $cart_item) {
            $product_item = $products->where('id', $cart_item->id)->first();
            $order_product = $order->products()->create([
                'product_id' => $product_item->id,
                'price' => $cart_item->price,
                'name'  => $product_item->name,
                'code'  => $product_item->code,
                'quantity' => $cart_item->qty,
            ]);

            $product_options = $cart_item->options->toArray();
            $option_ids = array_keys($product_options);
            $options = Option::whereIn('id', $option_ids)->get();
            $values = OptionValue::whereIn('option_values.option_id', $option_ids)
                ->select('option_values.*', 'product_to_option_value.prefix', 'product_to_option_value.price')
                ->join('product_to_option_value', 'product_to_option_value.value_id', '=', 'option_values.id')
                ->where('product_to_option_value.product_id', $product_item->id)
                ->get();

            foreach ($product_options as $option_id => $value_id) {
                $value_ids = (array) $value_id;
                $option_item = $options->where('id', $option_id)->first();

                foreach ($value_ids as $value_id) {
                    $value_item = $values->where('id', $value_id)->first();
                    $order->productOptions()->create([
                        'order_product_id' => $order_product->id,
                        'name' => $option_item->name,
                        'option_id' => $option_item->id,
                        'value_id' => $value_id,
                        'value' => $value_item->value,
                        'prefix' => $value_item->prefix,
                        'price' => $value_item->price,
                    ]);
                }
            }
        }
        
        \Cart::destroy();
        
        // Gửi thông tin xác nhận đơn hàng
        if (setting('confirm-order')) {
            \Auth::user()->notify(new \Packages\Ecommerce\Notifications\ConfirmOrder($order, \Auth::user()));
        }

        // Gửi thông tin đơn hàng đến quản trị viên
        if (!setting('confirm-order') && setting('order-notify-email') && count(setting('order-notify-email-user-role'))) {
            \Notification::send(\Packages\Cms\User::whereIn('role_id', setting('order-notify-email-user-role'))->get(), new \Packages\Ecommerce\Notifications\NewOrder($order));
        }

        if (!method_exists($this, 'responseStore')) {
            return $this->responseStore($request, $order);
        }

        if ($request->ajax()) {
            return response()->json([
                'title' => 'Đơn hàng đã được gửi',
                'message' => 'Đơn hàng đã được gửi đến chúng tôi',
            ]);
        }

        return redirect()->back()->with('message-success', 'Đơn hàng đã được gửi');
    }

    public function confirm(Request $request, $id)
    {
        $this->validate($request, [
            'confirm_token' => 'required',
        ]);

        $order = Order::findOrFail($id);
        $token = $request->input('confirm_token');

        $this->data['order'] = $order;
        $this->data['confirm_token'] = $token;

        if ($order->markAsConfirm($token)) {
            // Gửi đơn hàng đến quản trị viên
            if (setting('order-notify-email') && count(setting('order-notify-email-user-role'))) {
                \Notification::send(\Packages\Cms\User::whereIn('role_id', setting('order-notify-email-user-role'))->get(), new \Packages\Ecommerce\Notifications\NewOrder($order));
            }

            if (!method_exists($this, 'viewConfirmSuccess')) {
                return $this->viewConfirmSuccess($request, $order);
            }

            \Metatag::set('title', 'Xác nhận thành công');
            return view('Home::checkout.confirm.success', $this->data);
        }

        if (!method_exists($this, 'viewConfirmError')) {
            return $this->viewConfirmError($request, $order);
        }

        \Metatag::set('title', 'Xác nhận thất bại');
        return view('Home::checkout.confirm.error', $this->data);
    }
}
