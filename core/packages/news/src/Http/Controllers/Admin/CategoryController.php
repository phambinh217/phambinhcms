<?php

namespace Packages\News\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Packages\News\Category;
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
        $this->data['categories']    = Category::applyFilter($filter)->paginate($this->paginate);
        $this->data['filter'] = $filter;

        \Metatag::set('title', trans('news.category.list-category'));
        return view('News::admin.category.list', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $this->data['category'] = new Category();

        \Metatag::set('title', trans('news.category.add-new-category'));
        return view('News::admin.category.save', $this->data);
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
                'message'    =>    trans('news.category.create-menu-success'),
                'redirect'    =>    $request->exists('save_only') ?
                    route('admin.news.category.edit', ['id' => $category->id]) :
                    route('admin.news.category.create'),
            ]);
        }
        
        if ($request->exists('save_only')) {
            return redirect(route('admin.news.category.edit', ['id' => $category->id]));
        }

        return redirect(route('admin.news.category.create'));
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

        \Metatag::set('title', trans('news.category.edit-category'));
        return view('News::admin.category.save', $this->data);
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
        ]);

        $category->fill($request->input('category'));
        
        if (empty($category->slug)) {
            $category->slug = str_slug($category->title);
        }

        $category->save();

        if ($request->ajax()) {
            $response = [
                'title'      =>    trans('cms.success'),
                'message'    =>    trans('news.category.update-category-success'),
            ];
            if ($request->exists('save_and_out')) {
                $response['redirect'] = route('admin.news.category.index');
            }

            return response()->json($response, 200);
        }
        
        if ($request->exists('save_and_out')) {
            return redirect()->route('admin.news.category.index');
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
        if ($category->newses()->count()) {
            if ($request->ajax()) {
                return response()->json([
                    'title'        =>    trans('cms.error'),
                    'message'    =>    trans('news.category.category-has-news'),
                ], 422);
            }
            
            return redirect()->back();
        }

        $category->delete();
        
        if ($request->ajax()) {
            return response()->json([
                'title'            =>    trans('cms.success'),
                'message'        =>    trans('news.category.destroy-category-success'),
            ], 200);
        }

        return redirect()->back();
    }
}
