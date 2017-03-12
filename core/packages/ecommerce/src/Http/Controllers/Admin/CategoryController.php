<?php

namespace Packages\Ecommerce\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Packages\Ecommerce\Category;
use AdminController;
use Validator;

class CategoryController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $filter = Category::getRequestFilter();
        $this->data['categories'] = Category::applyFilter($filter)->with('products')->get();
        $this->data['filter'] = $filter;

        \Metatag::set('title', 'Danh sách danh mục');
        return view('Ecommerce::admin.category.list', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $this->data['category'] = new Category();
        return view('Ecommerce::admin.category.save', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'category.name'        => 'required|max:255',
            'category.slug'            => 'max:255',
            'category.description'    => 'max:300',
            'category.parent_id'    => 'integer',
        ]);

        $category = new Category();
        $category->fill($request->category);
        if (empty($category->slug)) {
            $category->slug = str_slug($category->name);
        }
        $category->save();

        if ($request->ajax()) {
            return response()->json([
                'title'        =>    trans('cms.success'),
                'message'    =>    'Đã thêm danh mục mới',
                'redirect'    =>    $request->exists('save_only') ?
                    route('admin.ecommerce.category.edit', ['id' => $category->id]) :
                    route('admin.ecommerce.category.create'),
            ]);
        }
        
        if ($request->exists('save_only')) {
            return redirect()->route('admin.ecommerce.category.edit', ['id' => $category->id]);
        }

        return redirect()->route('admin.ecommerce.category.create');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit(Category $category)
    {
        $this->data['category'] = $category;
        $this->data['category_id'] = $category->id;

        return view('Ecommerce::admin.category.save', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, Category $category)
    {
        $this->validate($request, [
            'category.name'        => 'required|max:255',
            'category.slug'            => 'max:255',
            'category.description'    => 'max:300',
            'category.parent_id'    => 'integer',
        ]);

        $category->fill($request->category);
        if (empty($category->slug)) {
            $category->slug = str_slug($category->name);
        }
        $category->save();

        if ($request->ajax()) {
            $response = [
                'title'        =>    trans('cms.success'),
                'message'    =>    'Đã cập nhật danh mục',
            ];
            if ($request->exists('save_and_out')) {
                $response['redirect'] = route('admin.ecommerce.category.index');
            }

            return response()->json($response, 200);
        }
        
        if ($request->exists('save_and_out')) {
            return redirect()->route('admin.ecommerce.category.index');
        }
                
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(Request $request, Category $category)
    {
        if ($category->products->count()) {
            if ($request->ajax()) {
                return response()->json([
                    'title'        =>    trans('cms.error'),
                    'message'    =>    'Danh mục đã có sản phẩm',
                ], 422);
            }
            
            return redirect()->back();
        }

        Category::where('parent_id', $category->id)->update(['parent_id' => $category->parent_id]);
        $category->delete();

        if ($request->ajax()) {
            return response()->json([
                'title'            =>    trans('cms.success'),
                'message'        =>    'Đã xóa danh mục',
            ], 200);
        }

        return redirect()->back();
    }

    public function multipleDestroy(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
        ]);

        $categories = Category::select('id', 'parent_id')->whereIn('id', $request->id)->with('products')->get();
        $success_id = [];
        $error_id = [];

        // Chỉ xóa danh mục mà chưa có sản phẩm
        foreach ($categories as $category_item) {
            if ($category_item->products->count() == 0) {
                Category::where('parent_id', $category_item->id)->update(['parent_id' => $category_item->parent_id]);
                $category_item->delete();
                $success_id[] = $category_item->id;
            } else {
                $error_id[] = $category_item->id;
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
