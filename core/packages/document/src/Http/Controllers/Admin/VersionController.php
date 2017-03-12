<?php

namespace Packages\Document\Http\Controllers\Admin;

use Illuminate\Http\Request;
use AdminController;
use Packages\Document\Version;

class VersionController extends AdminController
{
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $filter = Version::getRequestFilter();
        $this->data['versions']    = Version::applyFilter($filter)->paginate($this->paginate);
        $this->data['filter'] = $filter;

        \Metatag::set('title', 'Danh sách phiên bản bài viết');
        return view('Document::admin.version.list', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        \Metatag::set('title', 'Thêm phiên bản mới');

        $this->data['version'] = new Version();

        return view('Document::admin.version.save', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'version.name'        => 'required|max:255',
            'version.slug'            => 'max:255',
            'version.description'    => 'max:300',
        ]);

        $version = new Version();
        
        $version->fill($request->version);
        if (empty($version->slug)) {
            $version->slug = str_slug($version->title);
        }

        $version->save();

        if ($request->ajax()) {
            return response()->json([
                'title'        =>    trans('cms.success'),
                'message'    =>    trans('cms.success'),
                'redirect'    =>    $request->exists('save_only') ?
                    route('admin.document.version.edit', ['id' => $version->id]) :
                    route('admin.document.version.create'),
            ]);
        }
        
        if ($request->exists('save_only')) {
            return redirect(route('admin.document.version.edit', ['id' => $version->id]));
        }

        return redirect(route('admin.document.version.create'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit(Version $version)
    {
        \Metatag::set('title', 'Chỉnh sửa phiên bản');

        $this->data['version'] = $version;
        $this->data['version_id'] = $version->id;

        return view('Document::admin.version.save', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, Version $version)
    {
        $this->validate($request, [
            'version.name'        => 'required|max:255',
            'version.slug'            => 'max:255',
            'version.description'    => 'max:300',
        ]);

        $version->fill($request->input('version'));
        
        if (empty($version->slug)) {
            $version->slug = str_slug($version->title);
        }

        $version->save();

        if ($request->ajax()) {
            $response = [
                'title'      =>    trans('cms.success'),
                'message'    =>    'Đã cập nhật phiên bản',
            ];
            if ($request->exists('save_and_out')) {
                $response['redirect'] = route('admin.document.version.index');
            }

            return response()->json($response, 200);
        }
        
        if ($request->exists('save_and_out')) {
            return redirect()->route('admin.document.version.index');
        }
                
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(Request $request, Version $version)
    {
        if ($version->documents()->count()) {
            if ($request->ajax()) {
                return response()->json([
                    'title'        =>    trans('cms.error'),
                    'message'    =>    'Phiên bản đã có bài viết',
                ], 422);
            }
            
            return redirect()->back();
        }

        $version->delete();
        
        if ($request->ajax()) {
            return response()->json([
                'title'            =>    trans('cms.success'),
                'message'        =>    'Đã xóa phiên bản thành công',
            ], 200);
        }

        return redirect()->back();
    }
}
