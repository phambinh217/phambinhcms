<?php

namespace Packages\Deky\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Validator;
use AdminController;
use Packages\Deky\Student;

class StudentController extends AdminController
{
    public function index()
    {
        \Metatag::set('title', 'Danh sách học viên');

        $student = new Student();
        $filter = $student->getRequestFilter();
        $students = $student->applyFilter($filter)
            ->select('users.*')
            ->addSelect(\DB::raw('count(classes.id) as total_class'))
            ->leftjoin('classes', 'classes.student_id', '=', 'users.id')
            ->groupBy('users.id')
            ->paginate($this->paginate);
        
        $this->data['student']    = $student;
        $this->data['students'] = $students;
        $this->data['filter']    = $filter;

        return view('Student::admin.list', $this->data);
    }

    public function show(Student $student)
    {
        $this->data['student_id'] = $student->id;
        $this->data['student'] = $student;

        \Metatag::set('title', 'Xem học viên');
        return view('Student::admin.show', $this->data);
    }

    public function create()
    {
        \Metatag::set('title', 'Thêm học viên');
        $this->data['student'] = new Student();
        
        return view('Student::admin.save', $this->data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'student.name'                        => 'required|unique:users,name',
            'student.phone'                    => 'required|unique:users,phone',
            'student.email'                    => 'required|email|max:255|unique:users,email',
            'student.last_name'                => 'required|max:255',
            'student.first_name'                => 'required|max:255',
            'student.birth'                    => 'required|date_format:d-m-Y',
            'student.password'                    => 'required|confirmed',
            'student.password_confirmation'    => 'required',
            'student.status'                    => 'required|in:0,1',
        ]);

        $student = new Student();
        $student->fill($request->student);
        $student->birth = changeFormatDate($student->birth, 'd-m-Y', 'Y-m-d');
        $student->password = bcrypt($student->password);
        $student->role_id = setting('student_role_id');
        $student->save();

        if ($request->ajax()) {
            return response()->json([
                'title'        =>    trans('cms.success'),
                'message'    =>    trans('cms.success'),
                'redirect'    =>    $request->exists('save_only') ?
                    route('admin.student.edit', ['id' => $student->id]) :
                    route('admin.student.edit', ['id' => $student->id]),
            ], 200);
        }

        if ($request->exists('save_only')) {
            return redirect()->route('admin.student.edit', ['id' => $student->id]);
        }

        return redirect()->route('admin.student.edit', ['id' => $student->id]);
    }

    public function edit(Student $student)
    {   
        // Không thể tự chỉnh sửa thông tin của bản thân trong phương thức này
        // Sẽ tự đi vào trang cá nhân
        if ($student->isSelf()) {
            return redirect()->route('admin.profile.show');
        }

        $this->data['student_id'] = $id;
        $this->data['student'] = $student;
        \Metatag::set('title', 'Chỉnh sửa học viên');

        return view('Student::admin.save', $this->data);
    }

    public function update(Request $request, Student $student)
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
                'message'       =>    'Đã cập nhật thông tin',
            ];
            if ($request->exists('save_and_out')) {
                $response['redirect'] = route('admin.student.index');
            }

            return response()->json($response, 200);
        }
        
        if ($request->exists('save_and_out')) {
            return redirect()->route('admin.student.index');
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
                'message'    =>    'Đã ẩn học viên',
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
                'message'    =>    'Đã kích hoạt học viên',
            ], 200);
        }
        
        return redirect()->back();
    }

    public function destroy(Request $request, Student $student)
    {
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

        $student->delete();

        if ($request->ajax()) {
            return response()->json([
                'title'        =>    trans('cms.success'),
                'message'    =>    'Đã xóa học viên',
            ], 200);
        }
        
        return redirect()->back();
    }
}
