<?php

namespace Packages\SimpleShop\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use HomeController as CoreHomeController;
use Packages\Ecommerce\Product;
use Packages\Ecommerce\Support\Traits\CompareController as ShopCompareController;

class CompareController extends CoreHomeController
{
    use ShopCompareController;

    public function index()
    {
        \Metatag::set('title', 'giỏ so sánh');
        $this->data['products'] = Product::whereIn('id', \Compare::content()->pluck('id'))->with('brands')->get();
        
        return view('Home::compare.index', $this->data);
    }

    public function quickview()
    {
        return view('Home::partials.compare-quickview');
    }

    protected function responseStore(Request $request, Product $product)
    {
        if ($request->ajax()) {
            return response()->json([
                'title'        =>    'Đã thêm vào giỏ so sánh',
                'message'    =>    'Đã thêm <a href="'.route('product.show', ['slug' => $product->slug, 'id' => $product->id]).'">'.$product->name.'</a> vào <a href="'.route('compare.index').'">giỏ so sánh của bạn</a>',
                'count'        =>    \Compare::count(),
                'product'    =>    $product,
                'product_id'=>    $product->id,
                'thumbnail' =>    thumbnail_url($product->thumbnail, ['width' => 74, 'height' => 74]),
                'redirect'    =>    isset($request->rdr) ? $request->rdr : '',
            ]);
        }

        return redirect()->back()->with('message-success', 'Đã thêm <a href="'.route('product.show', ['slug' => $product->slug, 'id' => $product->id]).'">'.$product->name.'</a> vào <a href="'.route('compare.index').'">giỏ so sánh của bạn</a>');
    }

    protected function responseDestroy(Request $request, Product $product)
    {
        if ($request->ajax()) {
            return response()->json([
                'title'        =>    'Đã xóa khỏi giỏ so sánh',
                'message'    =>    'Đã xóa <a href="'.route('product.show', ['slug' => $product->slug, 'id' => $product->id]).'">'.$product->name.'</a> khỏi <a href="'.route('compare.index').'">giỏ so sánh của bạn</a>',
                'thumbnail' =>    thumbnail_url($product->thumbnail, ['width' => 74, 'height' => 74]),
                'product_id'=>    $product->id,
                'count'        =>    \Compare::count(),
                'product'    =>    $product,
                'redirect' => isset($request->rdr) ? $request->rdr : '',
            ]);
        }

        return redirect()->back()->with('Đã xóa <a href="'.route('product.show', ['slug' => $product->slug, 'id' => $product->id]).'">'.$product->name.'</a> khỏi <a href="'.route('compare.index').'">giỏ so sánh của bạn</a>');
    }

}
