<?php

namespace Phambinh\Cms\Http\Controllers\Api;

use Illuminate\Http\Request;
use ApiController;
use Phambinh\Cms\User;

class UserController extends ApiController
{
    public function index()
    {
        $User = new User();
        $filter = $User->getRequestFilter();
        $res = $User
            ->distinct()
            ->applyFilter($filter)
            ->select('users.*')
            ->get();

        return response()->json($res, 200);
    }

    public function genApiToken()
    {
        return response()->json([
            'api_token' => str_random(60),
        ]);
    }
}
