<?php

namespace Packages\Ecommerce\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Packages\Ecommerce\Filter;
use AdminController;
use Validator;

class FilterController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $query_filter = Filter::getRequestFilter();
        $this->data['filters']    = Filter::applyFilter($query_filter)->with('products')->paginate($this->paginate);
        $this->data['query_filter'] = $query_filter;

        return view('Ecommerce::admin.filter.list', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $this->data['filter'] = new Filter();
        return view('Ecommerce::admin.filter.save', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'filter.name'        => 'required|max:255',
            'filter.slug'            => 'max:255',
            'filter.description'    => 'max:300',
            'filter.parent_id'    => 'integer',
        ]);

        $filter = new Filter();
        $filter->fill($request->filter);
        if (empty($filter->slug)) {
            $filter->slug = str_slug($filter->name);
        }
        $filter->save();

        if ($request->ajax()) {
            return response()->json([
                'title'        =>    trans('cms.success'),
                'message'    =>    'Đã thêm bộ lọc mới',
                'redirect'    =>    $request->exists('save_only') ?
                    route('admin.ecommerce.filter.edit', ['id' => $filter->id]) :
                    route('admin.ecommerce.filter.create'),
            ]);
        }
        
        if ($request->exists('save_only')) {
            return redirect()->route('admin.ecommerce.filter.edit', ['id' => $filter->id]);
        }

        return redirect()->route('admin.ecommerce.filter.create');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit(Filter $filter)
    {
        $this->data['filter'] = $filter;
        $this->data['filter_id'] = $filter->id;

        return view('Ecommerce::admin.filter.save', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, Filter $filter)
    {
        $this->validate($request, [
            'filter.name'        => 'required|max:255',
            'filter.slug'            => 'max:255',
            'filter.description'    => 'max:300',
            'filter.parent_id'    => 'integer',
        ]);

        $filter->fill($request->filter);
        if (empty($filter->slug)) {
            $filter->slug = str_slug($filter->name);
        }
        $filter->save();

        if ($request->ajax()) {
            $response = [
                'title'        =>    trans('cms.success'),
                'message'    =>    'Đã cập nhật bộ lọc',
            ];
            if ($request->exists('save_and_out')) {
                $response['redirect'] = route('admin.ecommerce.filter.index');
            }

            return response()->json($response, 200);
        }
        
        if ($request->exists('save_and_out')) {
            return redirect()->route('admin.ecommerce.filter.index');
        }
                
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(Request $request, Filter $filter)
    {
        if ($filter->products->count()) {
            if ($request->ajax()) {
                return response()->json([
                    'title'        =>    trans('cms.error'),
                    'message'    =>    'Bộ lọc đã có sản phẩm',
                ], 422);
            }
            
            return redirect()->back();
        }

        $filter->delete();
        
        if ($request->ajax()) {
            return response()->json([
                'title'            =>    trans('cms.success'),
                'message'        =>    'Đã xóa bộ lọc',
            ], 200);
        }

        return redirect()->back();
    }

    public function multipleDestroy(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
        ]);

        $filters = Filter::select('id', 'parent_id')->whereIn('id', $request->id)->with('products')->get();
        $success_id = [];
        $error_id = [];

        // Chỉ xóa bộ lọc mà chưa có sản phẩm
        foreach ($filters as $filter_item) {
            if ($filter_item->products->count() == 0) {
                Filter::where('parent_id', $filter_item->id)->update(['parent_id' => $filter_item->parent_id]);
                $filter_item->delete();
                $success_id[] = $filter_item->id;
            } else {
                $error_id[] = $filter_item->id;
            }
        }

        if ($request->ajax()) {
            return response()->json([
                'title' => trans('cms.success'),
                'message' => 'Đã xóa '. count($success_id) .' bộ lọc',
                'success_id' => $success_id,
                'error_id' => $error_id,
            ]);
        }

        return redirect()->back()->message('message-success', 'Đã xóa '. count($success) .' bộ lọc');
    }
}
