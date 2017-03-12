<?php

namespace Packages\Deky\Http\Controllers\Admin;

use Illuminate\Http\Request;

use AdminController;
use Packages\Deky\Class1;
use Packages\Deky\Course;
use Packages\Deky\Student;
use Validator;
use Packages\Cms\User;
use Packages\Deky\PaymentHistory;
use Packages\Deky\StudentGroup;

class Class1Controller extends AdminController
{
    /**
     * Xem và quản lí học viên trong lớp học
     * @Note đổi tên phương thúc này thành show hoặc manage
     */
    public function index(Course $course)
    {
        $filter = Student::getRequestFilter([
            'course_id'    =>    $course->id,
            'orderby'    =>    'pivot_created_at',
        ]);

        $this->data['filter'] = $filter;
        $this->data['course'] = $course;
        $this->data['course_id'] = $course->d;
        $this->data['students'] = $course->students()->applyFilter($filter)->paginate($this->paginate);
        $this->data['student_groups'] = Group::get();

        \Metatag::set('title', 'Quản lí học viên');
        return view('Deky::admin.class1.list', $this->data);
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

        \Metatag::set('title', 'Chi tiết khóa học');
        return view('Deky::admin.class1.show', $this->data);
    }

    public function create(Course $course)
    {
        $this->data['course'] = $course;
        $this->data['course_id'] = $course->id;
        
        \Metatag::set('title', 'Thêm học viên vào lớp');
        return view('Deky::admin.class1.save', $this->data);
    }

    /**
     * Thêm học viên vào lớp học
     * nếu học viên chưa có trong database thì thêm học viên vào database trước
     *
     * @param
     * @return
     * @author BinhPham
     */
    public function store(Request $request, Course $course)
    {
        $this->validate($request, [
            'student.phone'            =>    'required',
            'student.email'                =>    'required',
            'student.first_name'        =>    'required',
            'student.last_name'            =>    'required',
            'student.birth'                =>    'required',
            'class.student_group_id'    =>    'required|exists:student_groups,id',
            'class.user_intro_id'        =>    'exists:users,id',
            'class.comment'                =>    'max:300',
        ]);
        $studentModel = new Student();

        if (! ($student = $studentModel->where('phone', $request->student['phone'])
            ->orWhere('email', $request->student['email'])->first())
       ) {
            $student = $studentModel;
            $student->fill($request->student);

            $student->password = bcrypt(setting('default-password'));
            $student->role_id = setting('student_role_id');
            $student->name = str_slug($student->full_name);
            $student->status = '1';
            $student->birth = changeFormatDate($student->birth, 'd-m-Y', 'Y-m-d');
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

        if ($student->inClass($course->id)) {
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
        $class->course_id    = $course->id;
        $class->student_group_id = setting('default-group-student-id');

        $class->save();

        if ($request->ajax()) {
            return response()->json([
                'title'        =>    trans('cms.success'),
                'message'    =>    trans('cms.success'),
                'redirect'    =>    $request->exists('save_only') ?
                    route('admin.course.class.show', ['id' => $course->id]) :
                    route('admin.course.class.create', ['id' => $course->id]),
            ], 200);
        }

        if ($request->exists('save_only')) {
            return redirect(route('admin.course.class.show', ['id' => $course->id]));
        }

        return redirect(route('admin.course.class.create', ['id' => $course->id]));
    }

    public function changeGroup(Request $request, Class1 $class)
    {
       
        $this->validate($request, [
            'group_id'    =>    'required|exists:student_groups,id',
        ]);

        $class->student_group_id = $request->group_id;
        $class->save();

        if ($request->ajax()) {
            return response([
                'title'    =>    trans('cms.success'),
                'message'    =>    'Đã thay đổi nhóm',
            ], 200);
        }

        return redirect()->back();
    }

    public function destroy(Request $request, Class1 $class)
    {
        $class->delete();
        
        if ($request->ajax()) {
            return response()->json([
                'title'            =>    trans('cms.success'),
                'message'        =>    'Đã xóa ',
            ], 200);
        }

        return redirect()->back();
    }

    public function popupPayment(Class1 $class)
    {
        $course = $class->course;
        $student = $class->student;
        $this->data['class'] = $class;
        $this->data['student'] = $student;
        $this->data['course'] = $course;
        $this->data['history'] = $class->payment_histories;

        return view('Deky::admin.class1.popup-payment', $this->data);
    }

    public function edit(Class1 $class)
    {
        $course = $class->course;
        $student = $class->student;
        $this->data['class_id'] = $class->id;
        $this->data['course'] = $course;
        $this->data['student'] = $student;
        $this->data['class'] = $class;

        \Metatag::set('title', 'Chỉnh sửa học viên');
        return view('Deky::admin.class1.save', $this->data);
    }

    public function update(Request $request, Class1 $class)
    {
        $course = $class->course;
        $student_id = $class->student_id;

        $this->validate($request, [
            'student.phone'            =>    'required|unique:users,phone,' . $student_id .',id',
            'student.email'            =>    'required|unique:users,email,' . $student_id .',id',
            'student.first_name'        =>    'required',
            'student.last_name'            =>    'required',
            'student.birth'                =>    'required',
            'class.student_group_id'    =>    'required|exists:student_groups,id',
            'class.user_intro_id'        =>    'exists:users,id',
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
                'title'        =>    trans('cms.success'),
                'message'    =>    'Đã cập nhật',
            ];
            if ($request->exists('save_and_out')) {
                $response['redirect'] = route('admin.course.class.show', ['id' => $course->id]);
            }

            return response()->json($response, 200);
        }
        
        if ($request->exists('save_and_out')) {
            return redirect()->route('admin.course.class.show', ['id' => $course->id]);
        }
                
        return redirect()->back();
    }

    public function paymentStore(Request $request, Class1 $class)
    {
        $this->validate($request, [
            'payment.value' => 'required',
            'payment.comment'    =>    'max:300',
        ]);

        $payment = new PaymentHistory();
        $payment->fill($request->payment);
        $payment->collecter_id = \Auth::user()->id;
        $payment->class_id = $class_id;
        $payment->save();

        if ($request->ajax()) {
            return response()->json([
                'title'        =>    trans('cms.success'),
                'message'    =>    'Đã lưu',
            ]);
        }

        return redirect()->back();
    }
}
