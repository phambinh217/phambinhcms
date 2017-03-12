<?php

namespace Packages\Deky\Http\Controllers\Admin;

use Illuminate\Http\Request;
use AdminController;
use Packages\Deky\Course;
use Packages\Deky\Category;
use Packages\Deky\Student;

class MyClassController extends AdminController
{
    public function index()
    {
        $course = new Course();
        $filter = $course->getRequestFilter([
            
        ]);
        $this->data['filter'] = $filter;
        $this->data['courses'] = $course->applyFilter($filter)->paginate($this->paginate);
        $this->data['course'] = $course;

        \Metatag::set('title', 'Lớp học của tôi');
        return view('Work::admin.my-class.list', $this->data);
    }

    public function show(Course $course)
    {
        $student = new Student();
        $filter = $student->getRequestFilter([
            'course_id'    =>    $course->id,
            'orderby'    =>    'pivot_created_at',
        ]);

        $this->data['student'] = $student;
        $this->data['filter'] = $filter;
        $this->data['course'] = $course;
        $this->data['course_id'] = $course->id;
        $this->data['students'] = $course->students()->applyFilter($filter)->paginate($this->paginate);

        \Metatag::set('title', 'Chi tiết lớp học');
        return view('Work::admin.my-class.show', $this->data);
    }
}
