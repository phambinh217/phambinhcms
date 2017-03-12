<?php

namespace Packages\Ecommerce\Http\Controllers\Api;

use Illuminate\Http\Request;
use ApiController;
use Validator;
use Packages\Ecommerce\Tag;

class TagController extends ApiController
{
    public function index()
    {
        $tag = new Tag();
        $filter = $tag->getRequestFilter();
        $res = $tag->applyFilter($filter)->get();

        return response()->json($res);
    }

    public function firstOrCreate(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        $res = Tag::firstOrCreate(['name' => $request->input('name')]);
        return response()->json($res);
    }
}
