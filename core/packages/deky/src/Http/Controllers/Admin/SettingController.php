<?php

namespace Packages\Deky\Http\Controllers\Admin;

use Illuminate\Http\Request;
use AdminController;
use Validator;
use Packages\Cms\User\Role;

class SettingController extends AdminController
{
    public function partner()
    {
        $this->data['roles'] = Role::get();
        $this->data['partner_role_id'] = setting('partner-role-id');
        $this->data['default_group_partner_id'] = setting('default-group-partner-id');
        
        \Metatag::set('title', 'Cài đặt học viên');
        return view('Partner::admin.setting.partner', $this->data);
    }

    public function partnerUpdate(Request $request)
    {
        $this->validate($request, [
            'partner_role_id' => 'required|integer|exists:roles,id',
        ]);
        
        setting()->sync('partner-role-id', $request->input('partner_role_id'));

        if ($request->ajax()) {
            return response()->json([
                'title' => trans('cms.success'),
                'message' => 'Đã cập nhật nhóm học viên',
            ]);
        }

        return redirect()->back();
    }

    public function trainer()
    {
        $this->data['roles'] = Role::get();
        $this->data['trainer_role_id'] = setting('trainer-role-id');
        
        \Metatag::set('title', 'Cài đặt học viên');
        return view('Trainer::admin.setting.trainer', $this->data);
    }

    public function trainerUpdate(Request $request)
    {
        $this->validate($request, [
            'trainer_role_id' => 'required|integer|exists:roles,id',
        ]);
        
        setting()->sync('trainer-role-id', $request->input('trainer_role_id'));

        if ($request->ajax()) {
            return response()->json([
                'title' => trans('cms.success'),
                'message' => 'Đã cập nhật nhóm học viên',
            ]);
        }

        return redirect()->back();
    }

    public function student()
    {
        $this->data['roles'] = Role::get();
        $this->data['student_role_id'] = setting('student-role-id');
        $this->data['default_group_student_id'] = setting('default-group-student-id');
        
        \Metatag::set('title', 'Cài đặt học viên');
        return view('Student::admin.setting.student', $this->data);
    }

    public function studentUpdate(Request $request)
    {
        $this->validate($request, [
            'student_role_id' => 'required|integer|exists:roles,id',
        ]);
        
        setting()->sync('student-role-id', $request->input('student_role_id'));

        if ($request->ajax()) {
            return response()->json([
                'title' => trans('cms.success'),
                'message' => 'Đã cập nhật nhóm học viên',
            ]);
        }

        return redirect()->back();
    }
}
