<?php

namespace Packages\Ecommerce\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Packages\Ecommerce\Attribute;
use AdminController;
use Validator;

class AttributeController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $filter = Attribute::getRequestFilter();
        $this->data['attributes']    = Attribute::applyFilter($filter)->with('products')->get();
        $this->data['filter'] = $filter;

        \Metatag::set('title', 'Danh sách thuộc tính');
        return view('Ecommerce::admin.attribute.list', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $this->data['attribute'] = new Attribute();
        return view('Ecommerce::admin.attribute.save', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'attribute.name'        => 'required|max:255',
            'attribute.slug'            => 'max:255',
            'attribute.description'    => 'max:300',
        ]);

        $attribute = new Attribute();
        $attribute->fill($request->attribute);
        if (empty($attribute->slug)) {
            $attribute->slug = str_slug($attribute->name);
        }
        $attribute->save();

        if ($request->ajax()) {
            return response()->json([
                'title'        =>    trans('cms.success'),
                'message'    =>    'Đã thêm thuộc tính mới',
                'redirect'    =>    $request->exists('save_only') ?
                    route('admin.ecommerce.attribute.edit', ['id' => $attribute->id]) :
                    route('admin.ecommerce.attribute.create'),
            ]);
        }
        
        if ($request->exists('save_only')) {
            return redirect()->route('admin.ecommerce.attribute.edit', ['id' => $attribute->id]);
        }

        return redirect()->route('admin.ecommerce.attribute.create');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit(Attribute $attribute)
    {
        $this->data['attribute'] = $attribute;
        $this->data['attribute_id'] = $attribute->id;

        return view('Ecommerce::admin.attribute.save', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, Attribute $attribute)
    {
        $this->validate($request, [
            'attribute.name'        => 'required|max:255',
            'attribute.slug'            => 'max:255',
            'attribute.description'    => 'max:300',
        ]);

        $attribute->fill($request->attribute);
        if (empty($attribute->slug)) {
            $attribute->slug = str_slug($attribute->name);
        }
        $attribute->save();

        if ($request->ajax()) {
            $response = [
                'title'        =>    trans('cms.success'),
                'message'    =>    'Đã cập nhật thuộc tính',
            ];
            if ($request->exists('save_and_out')) {
                $response['redirect'] = route('admin.ecommerce.attribute.index');
            }

            return response()->json($response, 200);
        }
        
        if ($request->exists('save_and_out')) {
            return redirect()->route('admin.ecommerce.attribute.index');
        }
                
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(Request $request, Attribute $attribute)
    {
        if ($attribute->products->count()) {
            if ($request->ajax()) {
                return response()->json([
                    'title'        =>    trans('cms.error'),
                    'message'    =>    'Thuộc tính này đã có sản phẩm',
                ], 422);
            }
            
            return redirect()->back();
        }

        $attribute->delete();

        if ($request->ajax()) {
            return response()->json([
                'title'            =>    trans('cms.success'),
                'message'        =>    'Đã xóa thuộc tính',
            ], 200);
        }

        return redirect()->back();
    }

    public function multipleDestroy(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
        ]);

        $success_id = [];
        $error_id = [];

        // Chỉ xóa danh mục mà chưa có sản phẩm
        foreach ($attributes as $attribute_item) {
            if ($attribute_item->products->count() == 0) {
                $attribute_item->delete();
                $success_id[] = $attribute_item->id;
            } else {
                $error_id[] = $attribute_item->id;
            }
        }

        if ($request->ajax()) {
            return response()->json([
                'title' => trans('cms.success'),
                'message' => 'Đã xóa '. count($success_id) .' danh mục',
                'success_id' => $success_id,
                'error_id' => $error_id,
            ]);
        }

        return redirect()->back()->message('message-success', 'Đã xóa '. count($success) .' danh mục');
    }
}
