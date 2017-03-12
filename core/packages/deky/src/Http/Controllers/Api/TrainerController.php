<?php 

namespace Packages\Deky\Http\Controllers\Api;

use Illuminate\Http\Request;
use ApiController;
use Packages\Deky\Trainer;

class TrainerController extends ApiController
{
    public function index()
    {
        $Trainer = new Trainer();
        $filter = $Trainer->getRequestFilter();
        $res = $Trainer
            ->distinct()
            ->applyFilter($filter)
            ->select('users.*')
            ->get();

        return response()->json($res, 200);
    }
}
