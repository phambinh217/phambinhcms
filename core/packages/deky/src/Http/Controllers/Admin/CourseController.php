<?php

namespace Packages\Deky\Http\Controllers\Admin;

use Illuminate\Http\Request;
use AdminController;
use Validator;
use Packages\Deky\Course;

class CourseController extends AdminController
{
    public function index()
    {
        $filter = Course::getRequestFilter();
        $this->data['filter'] = $filter;
        $this->data['courses'] = Course::applyFilter($filter)->with('trainer')->paginate($this->paginate);

        \Metatag::set('title', 'Danh sách khóa học');
        return view('Deky::admin.course.list', $this->data);
    }

    public function create()
    {
        $course = new Course();
        $this->data['course'] = $course;
        
        \Metatag::set('title', 'Thêm khóa học mới');
        return view('Deky::admin.course.save', $this->data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'course.title'            =>    'required|max:255',
            'course.time_open'        =>    'required|date_format:d-m-Y',
            'course.time_finish'    =>    'required|date_format:d-m-Y',
            'course.price'            =>    'required|numeric',
            'course.trainer_id'        =>    'required|exists:users,id',
            'course.content'        =>    'min:0',
            'course.category_id'    =>    'required|exists:course_categories,id',
            'course.status'            =>    'required|in:enable,disable,pending',
            'course.lesson'            =>    'required|integer',
            'course.test'            =>    'required|integer',
            'course.target'            =>    'required|max:300',
        ]);

        $course = new Course();
        $course->fill($request->course);

        switch ($course->status) {
            case 'disable':
                $course->status = '0';
                break;

            case 'enable':
                $course->status = '1';
                break;

            case 'pending':
                $course->status = '2';
                break;
        }

        $course->slug = str_slug($course->title);
        $course->author_id = \Auth::user()->id;
        $course->time_open = changeFormatDate($course->time_open, 'd-m-Y', 'Y-m-d');
        $course->time_finish = changeFormatDate($course->time_finish, 'd-m-Y', 'Y-m-d');
        $course->save();
        $course->categories()->sync((array) $request->input('course.category_id'));

        if ($request->ajax()) {
            return response()->json([
                'title'        =>    trans('cms.success'),
                'message'    =>    trans('cms.success'),
                'redirect'    =>    $request->exists('save_only') ?
                    route('admin.course.edit', ['id' => $course->id]) :
                    route('admin.course.create'),
            ], 200);
        }

        if ($request->exists('save_only')) {
            return redirect()->route('admin.course.edit', ['id' => $course->id]);
        }

        return redirect()->route('admin.course.create');
    }
    
    public function edit(Course $course)
    {
        $this->data['course_id'] = $course->id;
        $this->data['course'] = $course;

        \Metatag::set('title', 'Chỉnh sửa khóa học');
        return view('Deky::admin.course.save', $this->data);
    }

    public function update(Request $request, Course $course)
    {
        $this->validate($request, [
            'course.title'            =>    'required|max:255',
            'course.time_open'        =>    'required|date_format:d-m-Y',
            'course.time_finish'    =>    'required|date_format:d-m-Y',
            'course.price'            =>    'required|numeric',
            'course.trainer_id'        =>    'required|exists:users,id',
            'course.content'        =>    'min:0',
            'course.category_id'    =>    'required|exists:course_categories,id',
            'course.status'            =>    'required|in:enable,disable,pending',
            'course.lesson'            =>    'required|integer',
            'course.test'            =>    'required|integer',
            'course.target'            =>    'required|max:300',
        ]);

        $course->fill($request->course);
        
        switch ($course->status) {
            case 'disable':
                $course->status = '0';
                break;

            case 'enable':
                $course->status = '1';
                break;

            case 'pending':
                $course->status = '2';
                break;
        }

        if (empty($course->slug)) {
            $course->slug = str_slug($course->title);
        }

        $course->time_open = changeFormatDate($course->time_open, 'd-m-Y', 'Y-m-d');
        $course->time_finish = changeFormatDate($course->time_finish, 'd-m-Y', 'Y-m-d');
        $course->save();
        $course->categories()->sync((array) $request->course['category_id']);

        if ($request->ajax()) {
            $response = [
                'title'        =>    trans('cms.success'),
                'message'    =>    'Đã thêm khóa học mới',
            ];
            if ($request->exists('save_and_out')) {
                $response['redirect'] = route('admin.course.index');
            }

            return response()->json($response, 200);
        }
        
        if ($request->exists('save_and_out')) {
            return redirect(route('admin.course.index'));
        }
                
        return redirect()->back();
    }

    public function disable(Request $request, Course $course)
    {
        if ($course->students()->count()) {
            if ($request->ajax()) {
                return response()->json([
                    'title'        =>    trans('cms.error'),
                    'message'    =>    'Lớp học đã có học viên',
                ], 422);
            }
            
            return redirect()->back();
        }
        
        $course->status = '0';
        $course->save();
        if ($request->ajax()) {
            return response()->json([
                'title'            =>    trans('cms.success'),
                'message'        =>    'Đã xóa khóa học',
            ], 200);
        }

        return redirect()->back();
    }

    public function enable(Request $request, Course $course)
    {
        $course->status = '1';
        $course->save();
        if ($request->ajax()) {
            return response()->json([
                'title'            =>    trans('cms.success'),
                'message'        =>    'Đã công khai khóa học',
            ], 200);
        }

        return redirect()->back();
    }

    public function destroy(Request $request, Course $course)
    {
        if ($course->students()->count()) {
            if ($request->ajax()) {
                return response()->json([
                    'title'        =>    trans('cms.error'),
                    'message'    =>    'Lớp học đã có học viên',
                ], 422);
            }
            
            return redirect()->back();
        }

        $course->delete();
        
        if ($request->ajax()) {
            return response()->json([
                'title'            =>    trans('cms.success'),
                'message'        =>    'Đã xóa khóa học',
            ], 200);
        }

        return redirect()->back();
    }

    public function intro()
    {
        \Metatag::set('title', 'Giới thiệu khóa học');

        $category = new Category();
        $course    = new Course();
        
        $this->data['category'] = $category;
        $this->data['course'] = $course;
        $this->data['categories'] = $category->get();

        return view('Deky::admin.course.intro', $this->data);
    }

    public function popupShow(Course $course)
    {
        $this->data['course'] = $course;
        $this->data['course_id'] = $id;

        return view('Deky::admin.course.popup-show', $this->data);
    }
}
