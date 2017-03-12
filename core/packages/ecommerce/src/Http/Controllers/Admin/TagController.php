<?php

namespace Packages\Ecommerce\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Packages\Ecommerce\Tag;
use AdminController;
use Validator;

class TagController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $filter = Tag::getRequestFilter();
        $this->data['tags']    = Tag::applyFilter($filter)->with('products')->get();
        $this->data['filter'] = $filter;

        return view('Ecommerce::admin.tag.list', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $this->data['tag'] = new Tag();
        return view('Ecommerce::admin.tag.save', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'tag.name'        => 'required|max:255',
            'tag.slug'            => 'max:255',
            'tag.description'    => 'max:300',
        ]);

        $tag = new Tag();
        $tag->fill($request->tag);
        if (empty($tag->slug)) {
            $tag->slug = str_slug($tag->name);
        }
        $tag->save();

        if ($request->ajax()) {
            return response()->json([
                'title'        =>    trans('cms.success'),
                'message'    =>    'Đã thêm tag mới',
                'redirect'    =>    $request->exists('save_only') ?
                    route('admin.ecommerce.tag.edit', ['id' => $tag->id]) :
                    route('admin.ecommerce.tag.create'),
            ]);
        }
        
        if ($request->exists('save_only')) {
            return redirect()->route('admin.ecommerce.tag.edit', ['id' => $tag->id]);
        }

        return redirect()->route('admin.ecommerce.tag.create');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit(Tag $tag)
    {
        $this->data['tag'] = $tag;
        $this->data['tag_id'] = $tag->id;

        return view('Ecommerce::admin.tag.save', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, Tag $tag)
    {
        $this->validate($request, [
            'tag.name'        => 'required|max:255',
            'tag.slug'            => 'max:255',
            'tag.description'    => 'max:300',
        ]);

        $tag->fill($request->tag);
        if (empty($tag->slug)) {
            $tag->slug = str_slug($tag->name);
        }
        $tag->save();

        if ($request->ajax()) {
            $response = [
                'title'        =>    trans('cms.success'),
                'message'    =>    'Đã cập nhật thẻ',
            ];
            if ($request->exists('save_and_out')) {
                $response['redirect'] = route('admin.ecommerce.tag.index');
            }

            return response()->json($response, 200);
        }
        
        if ($request->exists('save_and_out')) {
            return redirect()->route('admin.ecommerce.tag.index');
        }
                
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(Request $request, Tag $tag)
    {
        if ($tag->products->count()) {
            if ($request->ajax()) {
                return response()->json([
                    'title'        =>    trans('cms.error'),
                    'message'    =>    'Thẻ đã có sản phẩm',
                ], 422);
            }
            
            return redirect()->back();
        }

        $tag->delete();

        if ($request->ajax()) {
            return response()->json([
                'title'            =>    trans('cms.success'),
                'message'        =>    'Đã xóa thẻ',
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

        // Chỉ xóa thẻ mà chưa có sản phẩm
        foreach ($tags as $tag_item) {
            if ($tag_item->products->count() == 0) {
                $tag_item->delete();
                $success_id[] = $tag_item->id;
            } else {
                $error_id[] = $tag_item->id;
            }
        }

        if ($request->ajax()) {
            return response()->json([
                'title' => trans('cms.success'),
                'message' => 'Đã xóa '. count($success_id) .' thẻ',
                'success_id' => $success_id,
                'error_id' => $error_id,
            ]);
        }

        return redirect()->back()->message('message-success', 'Đã xóa '. count($success) .' thẻ');
    }
}
