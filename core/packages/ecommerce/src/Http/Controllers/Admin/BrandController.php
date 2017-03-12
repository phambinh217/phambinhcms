<?php

namespace Packages\Ecommerce\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Packages\Ecommerce\Brand;
use AdminController;
use Validator;

class BrandController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $filter = Brand::getRequestFilter();
        $this->data['brands']    = Brand::applyFilter($filter)->with('products')->get();
        $this->data['filter'] = $filter;

        \Metatag::set('title', 'Danh sách thương hiệu');
        return view('Ecommerce::admin.brand.list', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $this->data['brand'] = new Brand();
        return view('Ecommerce::admin.brand.save', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'brand.name'        => 'required|max:255',
            'brand.slug'            => 'max:255',
            'brand.description'    => 'max:300',
            'brand.parent_id'    => 'integer',
        ]);

        $brand = new Brand();
        $brand->fill($request->brand);
        if (empty($brand->slug)) {
            $brand->slug = str_slug($brand->name);
        }
        $brand->save();

        if ($request->ajax()) {
            return response()->json([
                'title'        =>    trans('cms.success'),
                'message'    =>    trans('cms.success'),
                'redirect'    =>    $request->exists('save_only') ?
                    route('admin.ecommerce.brand.edit', ['id' => $brand->id]) :
                    route('admin.ecommerce.brand.create'),
            ]);
        }
        
        if ($request->exists('save_only')) {
            return redirect()->route('admin.ecommerce.brand.edit', ['id' => $brand->id]);
        }

        return redirect()->route('admin.ecommerce.brand.create');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit(Brand $brand)
    {
        $this->data['brand'] = $brand;
        $this->data['brand_id'] = $brand->id;

        return view('Ecommerce::admin.brand.save', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, Brand $brand)
    {
        $this->validate($request, [
            'brand.name'        => 'required|max:255',
            'brand.slug'            => 'max:255',
            'brand.description'    => 'max:300',
            'brand.parent_id'    => 'integer',
        ]);

        $brand->fill($request->brand);
        if (empty($brand->slug)) {
            $brand->slug = str_slug($brand->name);
        }
        $brand->save();

        if ($request->ajax()) {
            $response = [
                'title'        =>    trans('cms.success'),
                'message'    =>    'Đã cập nhật thương hiệu',
            ];
            if ($request->exists('save_and_out')) {
                $response['redirect'] = route('admin.ecommerce.brand.index');
            }

            return response()->json($response, 200);
        }
        
        if ($request->exists('save_and_out')) {
            return redirect()->route('admin.ecommerce.brand.index');
        }
                
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(Request $request, Brand $brand)
    {
        if ($brand->products->count()) {
            if ($request->ajax()) {
                return response()->json([
                    'title'        =>    trans('cms.error'),
                    'message'    =>    'Thương hiệu đã có sản phẩm',
                ], 422);
            }
            
            return redirect()->back();
        }

        Brand::where('parent_id', $category->id)->update(['parent_id' => $category->parent_id]);
        $brand->delete();
        
        if ($request->ajax()) {
            return response()->json([
                'title'            =>    trans('cms.success'),
                'message'        =>    'Đã xóa thương hiệu',
            ], 200);
        }

        return redirect()->back();
    }

    public function multipleDestroy(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
        ]);

        $brands = Brand::select('id', 'parent_id')->whereIn('id', $request->id)->with('products')->get();
        $success_id = [];
        $error_id = [];

        // Chỉ xóa thương hiệu mà chưa có sản phẩm
        foreach ($brands as $brand_item) {
            if ($brand_item->products->count() == 0) {
                Brand::where('parent_id', $brand_item->id)->update(['parent_id' => $brand_item->parent_id]);
                $brand_item->delete();
                $success_id[] = $brand_item->id;
            } else {
                $error_id[] = $brand_item->id;
            }
        }

        if ($request->ajax()) {
            return response()->json([
                'title' => trans('cms.success'),
                'message' => 'Đã xóa '. count($success_id) .' thương hiệu',
                'success_id' => $success_id,
                'error_id' => $error_id,
            ]);
        }

        return redirect()->back()->message('message-success', 'Đã xóa '. count($success) .' thương hiệu');
    }
}


