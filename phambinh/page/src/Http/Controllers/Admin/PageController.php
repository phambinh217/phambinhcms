<?php

namespace Phambinh\Page\Http\Controllers\Admin;

use Illuminate\Http\Request;
use AdminController;
use Validator;
use Phambinh\Page\Page;

class PageController extends AdminController
{
    public function index()
    {
        $filter = Page::getRequestFilter();
        $this->data['filter'] = $filter;
        $this->data['pages'] = Page::applyFilter($filter)->with('author')->paginate($this->paginate);

        \Metatag::set('title', trans('page.list-page'));
        return view('Page::admin.list', $this->data);
    }

    public function create()
    {
        $page = new Page();
        $this->data['page'] = $page;
        
        \Metatag::set('title', trans('page.add-new-page'));
        return view('Page::admin.save', $this->data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'page.title'            =>    'required|max:255',
            'page.content'            =>    'min:0',
            'page.status'            =>    'required|in:enable,disable',
        ]);

        $page = new Page();

        $page->fill($request->page)->save();

        if ($request->ajax()) {
            return response()->json([
                'title'        =>    trans('cms.success'),
                'message'    =>    trans('page.create-page-success'),
                'redirect'    =>    $request->exists('save_only') ?
                    route('admin.page.edit', ['id' => $page->id]) :
                    route('admin.page.create'),
            ], 200);
        }

        if ($request->exists('save_only')) {
            return redirect()->route('admin.page.edit', ['id' => $page->id]);
        }

        return redirect()->route('admin.page.create');
    }
    
    public function edit(Page $page)
    {
        $this->data['page_id'] = $page->id;
        $this->data['page']    = $page;

        \Metatag::set('title', trans('page.edit-page'));
        return view('Page::admin.save', $this->data);
    }

    public function update(Request $request, Page $page)
    {
        $this->validate($request, [
            'page.title'            =>    'required|max:255',
            'page.content'        =>    'min:0',
            'page.status'            =>    'required|in:enable,disable',
        ]);

        $page->fill($request->page)->save();

        if ($request->ajax()) {
            $response = [
                'title'        =>    trans('cms.success'),
                'message'    =>    trans('page.update-page-success'),
            ];
            if ($request->exists('save_and_out')) {
                $response['redirect'] = route('admin.page.index');
            }

            return response()->json($response, 200);
        }
        
        if ($request->exists('save_and_out')) {
            return redirect()->route('admin.page.index');
        }
                
        return redirect()->back();
    }

    public function disable(Request $request, Page $page)
    {
        $page->markAsDisable();
        if ($request->ajax()) {
            return response()->json([
                'title'            =>    trans('cms.success'),
                'message'        =>    trans('page.disable-page-success'),
            ], 200);
        }

        return redirect()->back();
    }

    public function enable(Request $request, Page $page)
    {
        $page->markAsEnable();
        if ($request->ajax()) {
            return response()->json([
                'title'            =>    trans('cms.success'),
                'message'        =>    trans('page.enable-page-success'),
            ], 200);
        }

        return redirect()->back();
    }

    public function destroy(Request $request, Page $page)
    {
        $page->delete();
        
        if ($request->ajax()) {
            return response()->json([
                'title'            =>    trans('cms.success'),
                'message'        =>    trans('page.destroy-page-success'),
            ], 200);
        }

        return redirect()->back();
    }
}
