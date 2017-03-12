<?php

namespace Packages\Ecommerce\Http\Controllers\Api;

use Illuminate\Http\Request;
use ApiController;
use Validator;
use Packages\Ecommerce\Option;

class OptionController extends ApiController
{
    public function index()
    {
        $option = new Option();
        $filter = $option->getRequestFilter();
        $res = $option->applyFilter($filter)->get();

        return response()->json($res);
    }

    public function firstOrCreate(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'type' => 'required',
        ]);

        $res = Option::firstOrCreate(['name' => $request->input('name'), 'type' => $request->input('type')]);
        return response()->json($res);
    }
}
