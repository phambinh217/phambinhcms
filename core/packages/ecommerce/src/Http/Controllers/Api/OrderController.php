<?php

namespace Packages\Ecommerce\Http\Controllers\Api;

use Illuminate\Http\Request;
use ApiController;
use Validator;
use Packages\Ecommerce\Order;
use Packages\Ecommerce\OrderProduct;
use Packages\Ecommerce\Option;

class OrderController extends ApiController
{
    public function products($id)
    {
        $order = Order::with('products', 'productOptions')->find($id);
        $res = [];

        foreach ($order->products as $order_product) {
            $res[] = [
                'product_info' => [
                    'id' => $order_product->id,
                    'name' => $order_product->name,
                    'code' => $order_product->code,
                ],
                'options' => $order->productOptions->where('order_product_id', $order_product->id)->toArray(),
                'price' => $order_product->price,
                'quantity' => $order_product->quantity,
            ];
        }

        return response()->json($res);
    }
}
