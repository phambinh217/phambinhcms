<?php

namespace Packages\Deky\Http\Controllers\Admin;

use Illuminate\Http\Request;
use AdminController;
use Packages\Deky\Course;
use Packages\Deky\Category;
use Packages\Deky\Student;
use Packages\Deky\Class1;
use Packages\Cms\User;

class MyStudentController extends AdminController
{
    /**
     * Hiển thị danh sách học viên của tôi
     */
    public function index()
    {
        $class = new Class1();
        $this->data['class'] = $class;

        $this->data['registries'] = $class->applyFilter(['user_intro_id' => \Auth::user()->id])
            ->with('student')
            ->orderBy('created_at', 'desc')
            ->paginate($this->paginate);

        $this->data['students'] = \Auth::user()->students()->applyFilter()
            ->select('users.*')->distinct()
            ->addSelect(\DB::raw('count(classes.id) as total_class'))
            ->groupBy('users.id')
            ->orderBy('users.created_at', 'desc')
            ->paginate($this->paginate);

        $this->data['courses'] = \Auth::user()->courses()
            ->applyFilter()
            ->select('courses.*')
            ->distinct()
            ->addSelect(\DB::raw('count(classes.id) as total_student'))
            ->groupBy('courses.id')
            ->paginate($this->paginate);

        \Metatag::set('title', 'Học viên của tôi');
        return view('Work::admin.my-student.list', $this->data);
    }

    /**
     * Xem tất cả lượt đăng ký
     */
    public function registry()
    {

        $student = new Student();
        $filter = $student->getRequestFilter();
        $students = \Auth::user()
            ->students()->applyFilter($filter)
            ->addSelect('student_groups.name as group_title')
            ->addSelect('courses.title as course_title')
            ->join('student_groups', 'classes.student_group_id', '=', 'student_groups.id')
            ->join('courses', 'classes.course_id', '=', 'courses.id')
            ->paginate($this->paginate);

        $this->data['student']    = $student;
        $this->data['students'] = $students;
        $this->data['filter']    = $filter;
        
        \Metatag::set('title', 'Tất cả lượt đăng ký');
        return view('Work::admin.my-student.registry', $this->data);
    }

    /**
     * Xem tất cả học viên của tôi
     */
    public function student()
    {
        \Metatag::set('title', 'Học viên của tôi');

        $student = new Student();
        $filter = $student->getRequestFilter();
        $students = \Auth::user()->students()
            ->applyFilter($filter)
            ->distinct()
            ->addSelect(\DB::raw('count(classes.id) as total_class'))
            ->groupBy('users.id')
            ->paginate($this->paginate);

        $this->data['student']    = $student;
        $this->data['students'] = $students;
        $this->data['filter']    = $filter;

        return view('Work::admin.my-student.student', $this->data);
    }

    /**
     * Xem tất cả các khóa học có học viên của tôi đăng ký
     */
    public function course()
    {
        \Metatag::set('title', 'Khóa học có học viên');

        $course = new Course();
        $filter = $course->getRequestFilter();
        $courses = \Auth::user()->courses()
            ->select('courses.*')
            ->distinct()
            ->applyFilter($filter)
            ->addSelect(\DB::raw('count(classes.id) as total_student'))
            ->groupBy('courses.id')
            ->paginate($this->paginate);

        $this->data['courses']    = $courses;
        $this->data['course']    = $course;
        $this->data['filter']    = $filter;

        return view('Work::admin.my-student.course', $this->data);
    }


    /**
     * Hiển thị form thêm quản trị viên
     */
    public function registryCreate()
    {
        \Metatag::set('title', 'Thêm lượt đăng ký mới');

        return view('Work::admin.my-student.save-registry', $this->data);
    }

    /**
     * Xử lí thêm quản trị viên vào database
     */
    public function registryStore(Request $request)
    {
        $this->validate($request, [
            'class.course_id'            =>    'required|integer|exists:courses,id',
            'student.phone'            =>    'required',
            'student.email'                =>    'required',
            'student.first_name'        =>    'required',
            'student.last_name'            =>    'required',
            'student.birth'                =>    'required',
            'class.comment'                =>    'max:300',
        ]);
        $studentModel = new User();

        if (! ($student = $studentModel->where('phone', $request->student['phone'])
            ->orWhere('email', $request->student['email'])->first())
       ) {
            $student = $studentModel;
            $student->fill($request->student);

            $student->password    = bcrypt(setting('default-password'));
            $student->role_id    = setting('student_role_id');
            $student->name        = str_slug($student->full_name);
            $student->status    = '1';
            $student->birth    = changeFormatDate($student->birth, 'd-m-Y', 'Y-m-d');
            $student->save();
        }

        if ($student->role_id != setting('student_role_id')) {
            if ($request->ajax()) {
                return response()->json([
                    'title'        =>    trans('cms.error'),
                    'message'    =>    'Thông tin không phù hợp với học viên',
                ], 422);
            }

            return redirect()->back();
        }

        if ($student->inClass($request->class['course_id'])) {
            if ($request->ajax()) {
                return response()->json([
                    'title'        =>    trans('cms.error'),
                    'message'    =>    'Học viên này đã có trong lớp',
                ], 422);
            }

            return redirect()->back();
        }

        $class = new Class1();
        $class->fill($request->class);
        $class->student_id    = $student->id;
        $class->student_group_id = setting('default-group-student-id');
        $class->user_intro_id    = \Auth::user()->id;
        $class->save();

        if ($request->ajax()) {
            return response()->json([
                'title'        =>    trans('cms.success'),
                'message'    =>    trans('cms.success'),
                'redirect'    =>    $request->exists('save_only') ?
                    route('admin.my-student.student') :
                    admin_url('work/my-student/create'),
            ], 200);
        }

        if ($request->exists('save_only')) {
            return redirect(admin_url('work/my-student/registry'));
        }

        return redirect(admin_url('work/my-student/registry/create'));
    }

    /**
     * Hiển thị form chỉnh sửa học viên
     */
    public function registryEdit(Class1 $class)
    {
        $course = $class->course;
        $student = $class->student;
        $this->data['class_id'] = $class->id;
        $this->data['course'] = $course;
        $this->data['student'] = $student;
        $this->data['class'] = $class;
        $this->data['student_id'] = $student->id;

        \Metatag::set('title', 'Chỉnh sửa lượt đăng ký');
        return view('Work::admin.my-student.save-registry', $this->data);
    }

    public function registryUpdate(Request $request, Class1 $class)
    {
        $course = $class->course;
        $student_id = $class->student_id;

        $this->validate($request, [
            'student.phone'            =>    'required|unique:users,phone,' . $student_id .',id',
            'student.email'            =>    'required|unique:users,email,' . $student_id .',id',
            'student.first_name'        =>    'required',
            'student.last_name'            =>    'required',
            'student.birth'                =>    'required',
            'class.course_id'            =>    'required|integer|exists:courses,id',
            'class.comment'                =>    'max:300',
        ]);

        $student = Student::find($student_id);
        $student->fill($request->student);
        $student->birth = changeFormatDate($student->birth, 'd-m-Y', 'Y-m-d');
        $student->save();

        $class->fill($request->class);
        $class->save();

        if ($request->ajax()) {
            $response = [
                'title'         =>    trans('cms.success'),
                'message'       =>    trans('cms.success'),
            ];
            if ($request->exists('save_and_out')) {
                $response['redirect'] = admin_url('work/my-student/registry');
            }

            return response()->json($response, 200);
        }
        
        if ($request->exists('save_and_out')) {
            return redirect(admin_url('work/my-student/registry'));
        }
                
        return redirect()->back();
    }

    public function disable(Request $request, Student $student)
    {
        // Hành động này không thể áp dụng với bản thân người đang đăng nhập
        if ($student->isSelf()) {
            if ($request->ajax()) {
                return response()->json([

                ], 422);
            }

            return redirect()->back();
        }

        $student->status = '0';
        $student->save();

        if ($request->ajax()) {
            return response()->json([
                'title'        =>    trans('cms.success'),
                'message'    =>    trans('cms.success'),
            ], 200);
        }

        return redirect()->back();
    }

    public function enable(Request $request, Student $student)
    {
        // Hành động này không thể áp dụng với bản thân người đang đăng nhập
        if ($student->isSelf()) {
            if ($request->ajax()) {
                return response()->json([

                ], 422);
            }

            return redirect()->back();
        }

        $student->status = '1';
        $student->save();

        if ($request->ajax()) {
            return response()->json([
                'title'        =>    trans('cms.success'),
                'message'    =>    trans('cms.success'),
            ], 200);
        }
        
        return redirect()->back();
    }

    public function destroy(Request $request, Student $student)
    {
        // Hành động này không thể áp dụng với bản thân người đang đăng nhập
        if ($student->isSelf()) {
            if ($request->ajax()) {
                return response()->json([

                ], 402);
            }

            return redirect()->back();
        }

        if ($student->hasClass()) {
            if ($request->ajax()) {
                return response()->json([
                    'title'        =>    trans('cms.error'),
                    'message'    =>    'Học viên này có dữ liệu trên hệ thống'
                ], 402);
            }

            return redirect()->back();
        }

        // $student->delete();

        if ($request->ajax()) {
            return response()->json([
                'title'        =>    trans('cms.success'),
                'message'    =>    trans('cms.success'),
            ], 200);
        }
        
        return redirect()->back();
    }

    public function studentEdit(Student $student)
    {
        // Không thể tự chỉnh sửa thông tin của bản thân trong phương thức này
        // Sẽ tự đi vào trang cá nhân
        if ($student->isSelf()) {
            return redirect()->route('admin.profile.show');
        }

        $this->data['student_id'] = $student->id;
        $this->data['student'] = $student;

        \Metatag::set('title', 'Chỉnh sửa học viên');
        return view('Work::admin.my-student.save-student', $this->data);
    }

    public function studentUpdate(Request $request, Student $student)
    {
        if ($student->isSelf()) {
            return response()->json([

            ], 422);
        }

        $this->validate($request, [
            'student.last_name'                => 'required|max:255',
            'student.first_name'                => 'required|max:255',
            'student.birth'                    => 'required|date_format:d-m-Y',
            'student.phone'                    => 'required|unique:users,phone,'.$student->id.',id',
            'student.email'                    => 'required|email|max:255|unique:users,email,'.$student->id.',id',
            'student.status'                    => 'required|in:0,1',
        ]);

        $student->fill($request->student);
        $student->birth = changeFormatDate($student->birth, 'd-m-Y', 'Y-m-d');
        $student->save();

        if ($request->ajax()) {
            $response = [
                'title'        =>    trans('cms.success'),
                'message'    =>    trans('cms.success'),
            ];
            if ($request->exists('save_and_out')) {
                $response['redirect'] = admin_url('work/my-student/student');
            }

            return response()->json($response, 200);
        }
        
        if ($request->exists('save_and_out')) {
            return redirect(admin_url('work/my-student/student'));
        }
                
        return redirect()->back();
    }
}
