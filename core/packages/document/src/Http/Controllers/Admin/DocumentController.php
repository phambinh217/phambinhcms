<?php

namespace Packages\Document\Http\Controllers\Admin;

use Illuminate\Http\Request;
use AdminController;
use Packages\Document\Document;

class DocumentController extends AdminController
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function index()
    {
        $filter = Document::getRequestFilter();
        $this->data['filter'] = $filter;
        $this->data['documents'] = Document::applyFilter($filter)->with('author')->paginate($this->paginate);

        \Metatag::set('title', 'Tất cả bài viết');
        return view('Document::admin.list', $this->data);
    }

    public function create()
    {
        \Metatag::set('title', 'Thêm bài viết mới');

        $document = new Document();
        $this->data['document'] = $document;
        
        return view('Document::admin.save', $this->data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'document.title'            =>    'required|max:255',
            'document.content'            =>    'min:0',
            'document.version_id'        =>    'required|exists:document_versions,id',
            'document.status'            =>    'required|in:enable,disable',
        ]);

        $document = new Document();

        $document->fill($request->document);
        $document->save();

        if ($request->ajax()) {
            return response()->json([
                'title'        =>    trans('cms.success'),
                'message'    =>    trans('cms.success'),
                'redirect'    =>    $request->exists('save_only') ?
                    route('admin.document.edit', ['id' => $document->id]) :
                    route('admin.document.create'),
            ], 200);
        }

        if ($request->exists('save_only')) {
            return redirect()->route('admin.document.edit', ['id' => $document->id]);
        }

        return redirect()->route('admin.document.create');
    }
    
    public function edit(Document $document)
    {
        $this->data['document_id'] = $document->id;
        $this->data['document']    = $document;

        \Metatag::set('title', 'Chỉnh sửa bài viết');
        return view('Document::admin.save', $this->data);
    }

    public function update(Request $request, Document $document)
    {
        $this->validate($request, [
            'document.title'            =>    'required|max:255',
            'document.content'        =>    'min:0',
            'document.version_id'    =>    'required|exists:document_versions,id',
            'document.status'            =>    'required|in:enable,disable',
        ]);

        $document->fill($request->document);

        if (empty($document->slug)) {
            $document->slug = str_slug($document->title);
        }

        $document->save();
        $document->versions()->sync((array) $request->document['version_id']);

        if ($request->ajax()) {
            $response = [
                'title'        =>    trans('cms.success'),
                'message'    =>    'Cập nhật bài viết thành công',
            ];
            if ($request->exists('save_and_out')) {
                $response['redirect'] = route('admin.document.index');
            }

            return response()->json($response, 200);
        }
        
        if ($request->exists('save_and_out')) {
            return redirect()->route('admin.document.index');
        }
                
        return redirect()->back();
    }

    public function disable(Request $request, Document $document)
    {
        $document->markAsDisable();
        if ($request->ajax()) {
            return response()->json([
                'title'            =>    trans('cms.success'),
                'message'        =>    'Đã ẩn bài viết',
            ], 200);
        }

        return redirect()->back();
    }

    public function enable(Request $request, Document $document)
    {
        $document->markAsEnable();
        if ($request->ajax()) {
            return response()->json([
                'title'            =>    trans('cms.success'),
                'message'        =>    'Đã công khai bài viết',
            ], 200);
        }

        return redirect()->back();
    }

    public function destroy(Request $request, Document $document)
    {
        $document->delete();
        
        if ($request->ajax()) {
            return response()->json([
                'title'            =>    trans('cms.success'),
                'message'        =>    'Đã xóa bài viết',
            ], 200);
        }

        return redirect()->back();
    }
}
