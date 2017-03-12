<?php

namespace Packages\SimpleShop\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use HomeController as CoreHomeController;
use Packages\Ecommerce\Product;
use Packages\Ecommerce\Support\Traits\CartController as ShopCartController;

class CartController extends CoreHomeController
{
    use ShopCartController;

    public function index()
    {
        \Metatag::set('title', 'Giỏ hàng');
        $this->data['products'] = Product::whereIn('id', \Cart::content()->pluck('id'))->get();
        
        return view('Home::cart.index', $this->data);
    }

    public function quickview()
    {
        return view('Home::partials.cart-quickview');
    }

    protected function responseStore(Request $request, Product $product)
    {
        if ($request->ajax()) {
            return [
                'title'         => 'Đã thêm vào giỏ hàng 1',
                'message'       => 'Đã thêm <a href="'.route('product.show', ['slug' => $product->slug, 'id' => $product->id]).'">'.$product->name.'</a> vào <a href="'.route('cart.index').'">giỏ hàng của bạn</a>',
                'total'         => \Cart::total(),
                'count'         => \Cart::count(),
                'product'       => $product,
                'product_id'    => $product->id,
                'thumbnail'     => thumbnail_url($product->thumbnail, ['width' => 74, 'height' => 74]),
                'redirect'      => isset($request->rdr) ? $request->rdr : '',
            ];
        }

        return redirect()->back()->with('message-success', 'Đã thêm <a href="'.route('product.show', ['slug' => $product->slug, 'id' => $product->id]).'">'.$product->name.'</a> vào <a href="'.route('cart.index').'">giỏ hàng của bạn</a>');
    }

    protected function responseDestroy(Request $request, Product $product)
    {
        if ($request->ajax()) {
            return response()->json([
                'title'        =>    'Đã xóa khỏi giỏ hàng',
                'message'    =>    'Đã xóa <a href="'.route('product.show', ['slug' => $product->slug, 'id' => $product->id]).'">'.$product->name.'</a> khỏi <a href="'.route('cart.index').'">giỏ hàng của bạn</a>',
                'thumbnail' =>    thumbnail_url($product->thumbnail, ['width' => 74, 'height' => 74]),
                'product_id'=>    $product->id,
                'total'        =>    \Cart::total(),
                'count'        =>    \Cart::count(),
                'product'    =>    $product,
                'redirect' => isset($request->rdr) ? $request->rdr : '',
            ]);
        }

        return redirect()->back()->with('Đã xóa <a href="'.route('product.show', ['slug' => $product->slug, 'id' => $product->id]).'">'.$product->name.'</a> khỏi <a href="'.route('cart.index').'">giỏ hàng của bạn</a>');
    }

    protected function responseUpdateMany(Request $request)
    {
        if ($request->ajax()) {
            return response()->json([
                'title'    => 'Đã cập nhật',
                'message'    => 'Giỏ hàng đã được cập nhật',
                'total'        =>    \Cart::total(),
                'count'        =>    \Cart::count(),
            ]);
        }

        return redirect()->back()->with('message-success', 'Đã cập nhật giỏ hàng');
    }
}
