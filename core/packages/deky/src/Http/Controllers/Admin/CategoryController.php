<?php

namespace Packages\Deky\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Packages\Deky\Category;
use AdminController;
use Validator;

class CategoryController extends AdminController
{
    public function index()
    {
        $category = new Category();
        $filter = $category->getRequestFilter();
        $this->data['category']    = $category;
        $this->data['categories']    = $category->applyFilter($filter)->paginate($this->paginate);
        $this->data['filter'] = $filter;

        return view('Deky::admin.course.category.list', $this->data);
    }

    public function create()
    {
        $this->data['category'] = new Category();
        return view('Deky::admin.course.category.save', $this->data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'category.title'        => 'required|max:255',
            'category.slug'            => 'max:255',
            'category.description'    => 'max:300',
        ]);

        $category = new Category();
        $category->fill($request->category);
        if (empty($category->slug)) {
            $category->slug = str_slug($category->title);
        }
        $category->save();

        if ($request->ajax()) {
            return response()->json([
                'title'        =>    trans('cms.success'),
                'message'    =>    'Đã thêm danh mục mới',
                'redirect'    =>    $request->exists('save_only') ?
                    route('admin.course.category.edit', ['id' => $category->id]) :
                    route('admin.course.category.create'),
            ]);
        }
        
        if ($request->exists('save_only')) {
            return redirect()->route('admin.course.category.edit', ['id' => $category->id]);
        }

        return redirect()->route('admin.course.category.create');
    }

    public function edit(Category $category)
    {
        $this->data['category'] = $category;
        $this->data['category_id'] = $category->id;

        return view('Deky::admin.course.category.save', $this->data);
    }

    public function update(Request $request, Category $category)
    {
        $this->validate($request, [
            'category.title'        => 'required|max:255',
            'category.slug'            => 'max:255',
            'category.description'    => 'max:300',
        ]);

        $category->fill($request->category);
        if (empty($category->slug)) {
            $category->slug = str_slug($category->title);
        }
        $category->save();

        if ($request->ajax()) {
            $response = [
                'title'        =>    trans('cms.success'),
                'message'    =>    'Đã cập nhật danh mục',
            ];
            if ($request->exists('save_and_out')) {
                $response['redirect'] = route('admin.course.category.index');
            }

            return response()->json($response, 200);
        }
        
        if ($request->exists('save_and_out')) {
            return redirect()->route('admin.course.category.index');
        }
                
        return redirect()->back();
    }

    public function destroy(Request $request, Category $category)
    {
        if ($category->courses()->count()) {
            if ($request->ajax()) {
                return response()->json([
                    'title'        =>    trans('cms.error'),
                    'message'    =>    'Danh mục đã có khóa học',
                ], 422);
            }
            
            return redirect()->back();
        }

        $category->delete();
        
        if ($request->ajax()) {
            return response()->json([
                'title'            =>    trans('cms.success'),
                'message'        =>    'Đã xóa danh mục',
            ], 200);
        }

        return redirect()->back();
    }
}
