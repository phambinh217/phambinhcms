<?php

namespace Packages\Ecommerce\Http\Controllers\Admin;

use Illuminate\Http\Request;
use AdminController;
use Packages\Ecommerce\Product;
use Packages\Ecommerce\ProductImage;

class ProductController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $filter = Product::getRequestFilter();
        $products = Product::select('products.*')->applyFilter($filter)->paginate($this->paginate);
        $this->data['products'] = $products;
        $this->data['filter'] = $filter;

        \Metatag::set('title', 'Danh sách sản phẩm');
        return view('Ecommerce::admin.product.list', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $product = new Product();
        $this->data['product'] = $product;
        
        \Metatag::set('title', 'Thêm sản phẩm');
        return view('Ecommerce::admin.product.save', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'product.name' => 'required',
            'product.content' => '',
            'product.slug' => 'max:255',
            'product.meta_title' => 'max:255',
            'product.meta_description' => 'max:300',
            'product.meta_keyword' => 'max:255',
            'product.tag' => 'max:255',
            'product.price' => 'required|numeric',
            'product.promotional_price' => 'required_if:is_sale,true',
            'product.subtract' => 'in:false,true',
            'product.quantity' => 'integer|required_if:product.subtract,true',
            'product.available_at' => 'date_format:d-m-Y',
            'product.status'    =>  'required',

            'category_id'    =>  'required',
            'brand_id'    =>  'required',
            'filters_id'    =>  '',

            'product.option'    =>  '',
            'product.attribute'    =>  '',

            'images.*.url'    =>  '',
        ]);

        $product = new Product();
        $product->fill($request->product);

        if (isset($product->subtract)) {
            $product->subtract == 'true' ? '1' : '0';
        }

        if (isset($product->status)) {
            $product->status == 'enable' ? '1' : '0';
        }

        if (!empty($product->slug)) {
            $product->slug = str_slug($product->name);
        }

        $product->save();

        if (count($request->category_id)) {
            $product->categories()->sync($request->category_id);
        }

        if (count($request->brand_id)) {
            $product->brands()->sync($request->brand_id);
        }

        if (count($request->filter_id)) {
            $product->brands()->sync($request->filter_id);
        }

        // Lưu tùy chọn
        if (count($request->options)) {
            $option_sync = [];
            $option_value_sync = [];
            foreach ($request->options as $option_id => $value) {
                if (!is_array($value)) {
                    $option_sync[$option_id] = ['value' => $value];
                } else {
                    $option_sync[] = $option_id;
                    foreach ($value as $value_id => $value_data) {
                        $option_value_sync[$value_id] = [
                            'price' => isset($value_data['price']) ? $value_data['price'] : '0',
                            'quantity' => isset($value_data['quantity']) ? $value_data['quantity'] : '0',
                            'subtract' => isset($value_data['subtract']) ? $value_data['subtract'] : '0'
                        ];
                    }
                }
            }

            if (count($option_sync)) {
                $product->options()->sync($option_sync);
            }

            if (count($option_value_sync)) {
                $product->optionValues()->sync($option_value_sync);
            }
        }

        // Lưu thuộc tính
        if (count($request->attributes)) {
            $attribute_sync = [];
            foreach ($request->attributes as $attribute_id => $attribute_value) {
                $attribute_sync[$attribute_id] = ['value' => $attribute_value];
            }
            $product->attributes()->sync($attribute_sync);
        }

        // Lưu ảnh
        if (count($request->images)) {
            $images = [];
            foreach ($request->images as $index => $image_item) {
                $images[] = new ProductImage([
                    'url'  => $image_item['url'],
                    'order' => $index,
                ]);
            }
            $product->images()->saveMany($images);
        }

        if ($request->ajax()) {
            return response()->json([
                'title'        =>    trans('cms.success'),
                'message'    =>    trans('cms.success'),
                'redirect'    =>    $request->exists('save_only') ?
                    route('admin.ecommerce.product.edit', ['id' => $product->id]) :
                    route('admin.ecommerce.product.create'),
            ], 200);
        }

        if ($request->exists('save_only')) {
            return redirect(route('admin.ecommerce.product.edit', ['id' => $product->id]));
        }

        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $this->data['product'] = $product;
        $this->data['product_id'] = $product->id;

        \Metatag::set('title', 'Chỉnh sửa sản phẩm');
        return view('Ecommerce::admin.product.save', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $this->validate($request, [
            'product.name' => 'required',
            'product.content' => '',
            'product.slug' => 'max:255',
            'product.meta_title' => 'max:255',
            'product.meta_description' => 'max:300',
            'product.meta_keyword' => 'max:255',
            'product.tag' => 'max:255',
            'product.price' => 'required|numeric',
            'product.promotional_price' => 'required_if:is_sale,true',
            'product.subtract' => 'in:false,true',
            'product.quantity' => 'integer|required_if:product.subtract,true',
            'product.available_at' => 'date_format:d-m-Y',
            'product.status'    =>  'required|in:enable,disable',

            'category_id.*'    =>  'required|integer|exists:shop_categories,id',
            'brand_id.*'    =>  'required|integer|exists:brands,id',
            'filters_id.*'    =>  'integer|exists:filters,id',

            'options.*.required' => 'sometimes|required|in:true,false',
            'options.*.value' => 'sometimes|required',
        ]);

        $product = Product::find($id);
        $product->fill($request->product);

        if (isset($product->subtract)) {
            $product->subtract = ($product->subtract == 'true' ? '1' : '0');
        }

        if (isset($product->status)) {
            $product->status = ($product->status == 'enable' ? '1' : '0');
        }

        if (!empty($product->slug)) {
            $product->slug = str_slug($product->name);
        }

        $product->save();

        if ($request->has('category_id')) {
            $product->categories()->sync($request->input('category_id'));
        }

        if ($request->has('brand_id')) {
            $product->brands()->sync($request->input('brand_id'));
        }

        if ($request->has('filter_id')) {
            $product->filters()->sync($request->input('filter_id'));
        }

        if ($request->has('tag_id')) {
            $product->tags()->sync($request->input('tag_id'));
        }

        // Lưu tùy chọn
        if ($request->has('options')) {
            $option_sync = [];
            $option_value_sync = [];
            dd($request->input('options'));
            foreach ($request->input('options') as $option_id => $option_data) {
                $value = $option_data['value'];
                $option_sync[$option_id]['required'] = $option_data['required'] == 'true' ? '1' : '0';
                $option_sync[$option_id]['type'] = $option_data['type'];

                if (!is_array($value)) {
                    $option_sync[$option_id]['value'] = $value;
                } else {
                    foreach ($value as $value_id => $value_data) {
                        $option_value_sync[$value_id] = [
                            'option_id' => $option_id,
                            'prefix' => isset($value_data['prefix']) && $value_data['prefix'] == '-' ? '-' : '+',
                            'price' => isset($value_data['price']) ? $value_data['price'] : '0',
                            'quantity' => isset($value_data['quantity']) ? $value_data['quantity'] : '0',
                            'subtract' => isset($value_data['subtract']) && $value_data['subtract'] == 'true' ? '1' : '0',
                        ];
                    }
                }
            }

            if (count($option_sync)) {
                $product->options()->sync($option_sync);
            }

            if (count($option_value_sync)) {
                $product->optionValues()->sync($option_value_sync);
            }
        }

        // Lưu thuộc tính
        if ($request->has('attributes')) {
            $attribute_sync = [];
            $index = 0;
            foreach ($request->input('attributes') as $attribute_id => $attribute_value) {
                $attribute_sync[$attribute_id] = ['value' => $attribute_value, 'order' => $index];
                $index++;
            }
            $product->attributes()->sync($attribute_sync);
        }

        // Lưu ảnh
        if ($request->has('images')) {
            $images = [];
            foreach ($request->input('images') as $index => $image_item) {
                $images[] = new ProductImage([
                    'url'  => $image_item['url'],
                    'order' => $index,
                ]);
            }
            $product->images()->delete();
            $product->images()->saveMany($images);
        }

        if ($request->ajax()) {
            $res = [
                'title'        =>    trans('cms.success'),
                'message'    =>    trans('cms.success'),
            ];
            if ($request->exists('save_and_out')) {
                $response['redirect'] = route('admin.ecommerce.product.index');
            }
            return response()->json($res, 200);
        }
        
        if ($request->exists('save_and_out')) {
            return redirect()->route('admin.ecommerce.product.index');
        }
                
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Product $product)
    {
        $product->delete();

        if ($request->ajax()) {
            return response()->json([
                'title' => 'Đã xóa',
                'message' => 'Đã xóa '.$product->name,
            ]);
        }

        return redirect()->back()->with('message-success', 'Đã xóa '.$product->name);
    }

    public function popupEditQuantity(Product $product)
    {
        $this->data['product'] = $product;
        $this->data['product_id'] = $product->id;

        return view('Ecommerce::admin.product.popup-edit-quantity', $this->data);
    }

    public function updateQuantity(Request $request, Product $product)
    {
        $this->validate($request, [
            'product.quantity' => 'integer',
            'product.subtract' => 'in:0,1',
        ]);

        $product->quantity = $request->product['quantity'];
        $product->subtract = $request->product['subtract'];

        if ($request->ajax()) {
            return response()->json([
                'title' => trans('cms.success'),
                'message' => 'Cập nhật số lượng thành công',
            ]);
        }

        return redirect()->back()->with('message-success', 'Cập nhật số lượng thành công');
    }

    public function enable(Request $request, Product $product)
    {
        $product->markAsEnable();

        if ($request->ajax()) {
            return response()->json([
                'title' => trans('cms.success'),
                'message' => 'Đã công khai sản phẩm '.$product->name,
                ]);
        }

        return redirect()->back()->with('message-success', 'Đã công khai sản phẩm '.$product->name);
    }

    public function disable(Request $request, Product $product)
    {
        $product->markAsDisable();

        if ($request->ajax()) {
            return response()->json([
                'title' => trans('cms.success'),
                'message' => 'Đã ẩn sản phẩm '.$product->name,
                ]);
        }

        return redirect()->back()->with('message-success', 'Đã ẩn sản phẩm '.$product->name);
    }

    public function multipleEnable(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
        ]);

        $products = Product::whereIn('id', $request->input('id'))->update([
            'status' => 1,
        ]);

        if ($request->ajax()) {
            return response()->json([
                'title' => trans('cms.success'),
                'message' => 'Đã công khai '. count($request->input('id')) .' sản phẩm',
                'success_id' => $request->input('id'),
            ]);
        }

        return redirect()->back()->message('message-success', 'Đã công khai '. count($request->id) .' sản phẩm');
    }

    public function multipleDisable(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
        ]);

        $products = Product::whereIn('id', $request->input('id'))->update([
            'status' => '0',
        ]);

        if ($request->ajax()) {
            return response()->json([
                'title' => trans('cms.success'),
                'message' => 'Đã ẩn '. count($request->input('id')) .' sản phẩm',
                'success_id' => $request->input('id'),
            ]);
        }

        return redirect()->back()->message('message-success', 'Đã ẩn '. count($request->id) .' sản phẩm');
    }

    public function multipleDestroy(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
        ]);

        $products = Product::whereIn('id', $request->input('id'))->delete();

        if ($request->ajax()) {
            return response()->json([
                'title' => trans('cms.success'),
                'message' => 'Đã xóa '. count($request->input('id')) .' sản phẩm',
                'success_id' => $request->input('id'),
            ]);
        }

        return redirect()->back()->message('message-success', 'Đã xóa '. count($request->id) .' sản phẩm');
    }

    public function browser()
    {
        $this->data['products'] = Product::select('id', 'name', 'slug', 'thumbnail', 'code', 'price', 'promotional_price')->take($this->paginate)->get();
        
        return view('Ecommerce::admin.product.browser', $this->data);
    }
}
