<?php

namespace Packages\Ecommerce\Support\Traits;

use Illuminate\Http\Request;
use Packages\Ecommerce\Product;
use Validator;

trait CartController
{
    /**
     * Thêm sản phẩm vào giỏ hàng
     */
    public function store(Request $request)
    {
        $validator =  Validator::make($request->all(), [
            'product_id'    => 'exists:products,id|required',
            'quantity'        => 'required|integer',
        ]);

        $product = Product::select('id', 'name', 'price', 'thumbnail', 'promotional_price')->findOrFail($request->input('product_id'));
        
        if ($product->hasOptionRequired()) {
            $options_required = $product->optionRequired()->get();
            foreach ($options_required as $option_item) {
                $validator->mergeRules('product.option.' . $option_item->option_id, 'required');
            }
        }
        
        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json($validator->errors()->getMessages(), 422);
            }

            return redirect()->back()->withErrors($validator, 'errors');
        }

        $cart_data = [
            'id'    => $product->id,
            'name'    => $product->name,
            'qty'    => $request->input('quantity'),
        ];
        
        if ($request->has('product.option')) {
            $options = [];
            
            foreach ($request->input('product.option') as $option_key => $option_value) {
                if (!empty($option_value)) {
                    $options[$option_key] = $option_value;
                }
            }

            $cart_data['options']    = $options;
            $cart_data['price'] = $product->calPrice($options);
        } else {
            $cart_data['price']    = $product->calPrice();
        }

        \Cart::add($cart_data);

        if (method_exists($this, 'responseStore')) {
            return $this->responseStore($request, $product);
        }

        if ($request->ajax()) {
            return [
                'title'         => 'Đã thêm vào giỏ hàng',
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

    /**
     * Xóa sản phẩm
     */
    public function destroy(Request $request, $product_row_id)
    {
        $cart_item = \Cart::content()->where('rowId', $product_row_id)->first();
        
        if ($cart_item->rowId) {
            \Cart::remove($cart_item->rowId);
        }
        
        $product = Product::select('id', 'name', 'price', 'thumbnail')->findOrFail($cart_item->id);

        if (method_exists($this, 'responseDestroy')) {
            return $this->responseDestroy($request, $product);
        }

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

    /**
     * Cập nhật giỏ hàng
     */
    public function updateMany(Request $request)
    {
        $this->validate($request, [
            'product.*.rowId'    => 'required',
            'product.*.quantity'    => 'required',
        ]);

        foreach ($request->product as $product) {
            $cart_item = \Cart::content()->where('rowId', $product['rowId'])->first();
            if ($cart_item->rowId) {
                \Cart::update($cart_item->rowId, $product['quantity']);
            }
        }

        if (method_exists($this, 'responseUpdateMany')) {
            return $this->responseUpdateMany($request);
        }

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
