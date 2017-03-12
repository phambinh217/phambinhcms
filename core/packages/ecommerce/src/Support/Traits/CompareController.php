<?php

namespace Packages\Ecommerce\Support\Traits;

use Illuminate\Http\Request;
use Packages\Ecommerce\Product;
use Validator;

trait CompareController
{
    public function store(Request $request)
    {
        $validator =  Validator::make($request->all(), [
            'product_id'    => 'exists:products,id|required',
        ]);

        $product = Product::select('id', 'name', 'price', 'thumbnail', 'promotional_price')->findOrFail($request->product_id);
        
        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json($validator->errors()->getMessages(), 422);
            }

            return redirect()->back()->withErrors($validator, 'errors');
        }

        $compare_data = [
            'id'    => $product->id,
            'name'    => $product->name,
            'qty'    => 1,
        ];
        
        if (isset($request->product['option'])) {
            $options = [];
            
            foreach ($request->product['option'] as $option_key => $option_value) {
                if (!empty($option_value)) {
                    $options[$option_key] = $option_value;
                }
            }

            $compare_data['options']    = $options;
            $compare_data['price'] = $product->calPrice($options);
        } else {
            $compare_data['price']    = $product->calPrice();
        }

        \Compare::add($compare_data);

        if (method_exists($this, 'responseStore')) {
            return $this->responseStore($request, $product);
        }

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

    public function destroy(Request $request, $product_row_id)
    {
        $compare_item = \Compare::content()->where('rowId', $product_row_id)->first();
        
        if ($compare_item->rowId) {
            \Compare::remove($compare_item->rowId);
        }
        
        $product = Product::select('id', 'name', 'price', 'thumbnail')->findOrFail($compare_item->id);

        if (method_exists($this, 'responseDestroy')) {
            return $this->responseDestroy($request, $product);
        }

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
