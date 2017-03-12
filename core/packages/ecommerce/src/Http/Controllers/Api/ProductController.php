<?php

namespace Packages\Ecommerce\Http\Controllers\Api;

use Illuminate\Http\Request;
use ApiController;
use Validator;
use Packages\Ecommerce\Product;
use Packages\Ecommerce\ProductImage;
use Packages\Ecommerce\Option;

class ProductController extends ApiController
{
    public function index()
    {
        $product = new Product();
        $filter = $product->getRequestFilter();
        $res = $product->applyFilter($filter)->get();

        return response()->json($res);
    }

    public function show($id)
    {
        $product = Product::find($id);
        $res = $product;
        return response()->json($res);
    }

    public function images($id)
    {
        $images = ProductImage::where('product_id', $id)->get();
        $res = $images;
        return response()->json($res);
    }

    public function options($id)
    {
        $results = \DB::table('product_to_option_value')
            ->select('product_to_option_value.*', 'options.name as option_name', 'options.type as option_type', 'option_values.value as option_value', 'product_to_option.required as option_required')
            ->join('options', 'options.id', '=', 'product_to_option_value.option_id')
            ->join('option_values', 'option_values.id', '=', 'product_to_option_value.value_id')
            ->join('product_to_option', 'product_to_option.option_id', '=', 'product_to_option_value.option_id')
            ->where('product_to_option.product_id', '=', $id)
            ->where('product_to_option_value.product_id', $id)
            ->get()->groupBy('option_id');

        $res = [];
        foreach ($results as $option_item => $option_data) {
            $option = $option_data->first();
            if (in_array($option->option_type, ['select', 'checkbox', 'radio'])) {
                $res[] = [
                    'id' => $option->id,
                    'product_id' => $option->product_id,
                    'option_id' => $option->option_id,
                    'name' => $option->option_name,
                    'type' => $option->option_type,
                    'required' => $option->option_required,
                    'value' => $option_data,
                ];
            }
        }

        return response()->json($res);
    }
}
