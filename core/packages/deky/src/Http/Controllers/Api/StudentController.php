<?php 

namespace Packages\Deky\Http\Controllers\Api;

use Illuminate\Http\Request;
use ApiController;
use Packages\Deky\Student;

class StudentController extends ApiController
{
    public function index()
    {
        $student = new Student();
        $filter = $student->getRequestFilter();
        $res = $student->applyFilter($filter)->get();

        return response()->json($res, 200);
    }
}
