<?php

namespace Packages\Ecommerce\Http\Controllers\Api;

use Illuminate\Http\Request;
use ApiController;
use Validator;
use Packages\Ecommerce\OptionValue;

class OptionValueController extends ApiController
{
    public function index()
    {
        $option_value = new OptionValue();
        $filter = $option_value->getRequestFilter();
        $res = $option_value->applyFilter($filter)->get();

        return response()->json($res);
    }

    public function firstOrCreate(Request $request)
    {
        $this->validate($request, [
            'value' => 'required',
            'option_id' => 'integer|exists:options,id',
        ]);

        $res = OptionValue::firstOrCreate(['value' => $request->input('value'), 'option_id' => $request->input('option_id')]);
        return response()->json($res);
    }
}
