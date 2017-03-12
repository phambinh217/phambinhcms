<?php

namespace Packages\Ecommerce\Http\Controllers\Api;

use Illuminate\Http\Request;
use ApiController;
use Validator;
use Packages\Ecommerce\Attribute;

class AttributeController extends ApiController
{
    public function index()
    {
        $attribute = new Attribute();
        $filter = $attribute->getRequestFilter();
        $res = $attribute->applyFilter($filter)->get();

        return response()->json($res);
    }

    public function firstOrCreate(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        $res = Attribute::firstOrCreate(['name' => $request->input('name')]);
        return response()->json($res);
    }
}
