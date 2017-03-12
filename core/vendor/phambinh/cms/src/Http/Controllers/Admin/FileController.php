<?php

namespace Phambinh\Cms\Http\Controllers\Admin;

use Illuminate\Http\Request;

class FileController extends AdminController
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'files' => 'required',
        ]);

        $pathUpload = image_path();

        $results = [];

        $dataFile = [];

        $files = $request->file('files');
        if (! $files) {
            $files = $request->file();
        }

        $urlFiles = [];
        foreach ($files as $file) {
            if ($file->isValid()) {
                $urlFiles[] = image_url($file->getClientOriginalName());
                $info = $file->move($pathUpload, $file->getClientOriginalName());
            }
        }

        if ($request->ajax()) {
            return response()->json([
                'message'   =>  trans('cms.success'),
                'data'       =>    $results,
                'url'        => $urlFiles,
            ], 200);
        }
    }
}
