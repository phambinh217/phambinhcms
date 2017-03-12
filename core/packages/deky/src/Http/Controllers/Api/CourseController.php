<?php 

namespace Packages\Deky\Http\Controllers\Api;

use Illuminate\Http\Request;
use ApiController;
use Packages\Deky\Course;

class CourseController extends ApiController
{
    public function index()
    {
        $filter = Course::getRequestFilter();
        $res = Course::applyFilter($filter)->get();

        // $res = $course->applyFilter($filter)
        //     ->select('courses.*', 'course_meta.value as thumbnail', 'users.first_name as trainer_first_name', 'users.last_name as trainer_last_name')
        //     ->addSelect(\DB::raw('count(classes.id) as total_student'))
        //     ->leftjoin('course_meta', 'courses.id', '=', 'course_meta.course_id')
        //     ->leftjoin('classes', 'courses.id', '=', 'classes.course_id')
        //     ->groupBy('courses.id')
        //     ->join('users', 'users.id', '=', 'courses.trainer_id')
        //     ->get();

        return response()->json($res, 200);
    }
}
