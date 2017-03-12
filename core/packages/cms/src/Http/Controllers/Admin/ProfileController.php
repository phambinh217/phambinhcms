<?php

namespace Packages\Cms\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Auth;
use Validator;

class ProfileController extends AdminController
{
    public function show()
    {
        $this->data['user'] = Auth::user();

        \Metatag::set('title', trans('user.account-info'));
        return view('Cms::admin.profile.show', $this->data);
    }

    public function edit()
    {
        $this->data['user'] = Auth::user();

        \Metatag::set('title', trans('user.edit-profile'));
        return view('Cms::admin.profile.edit', $this->data);
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'user.first_name'    =>    'required|max:255',
            'user.last_name'    =>    'required|max:255',
            'user.birth'        =>  'required|date_format:d-m-Y',
            'user.phone'        =>    'max:255',
            'user.about'        =>    'max:500',
            'user.facebook'        =>    'max:255',
            'user.website'        =>    'max:255',
            'user.job'            =>    'max:255',
            'user.google_plus'    =>    'max:255',
            'user.address'      => 'max:300',
            'user.api_token'    =>  'required',
        ]);

        Auth::user()->fill($request->input('user'));
        Auth::user()->save();

        if ($request->ajax()) {
            return response()->json([
                'title'        =>    trans('cms.success'),
                'message'    =>    trans('user.update-profile-success'),
            ], 200);
        }

        return redirect()->back();
    }

    public function changePassword()
    {
        $this->data['user'] = Auth::user();

        \Metatag::set('title', trans('user.change-password'));
        return view('Cms::admin.profile.change-password', $this->data);
    }

    public function updatePassword(Request $request)
    {
        $this->validate($request, [
            'user.old_pasword'                  =>    'required|hash:' . Auth::user()->password,
            'user.password'                     =>    'required|confirmed',
            'user.password_confirmation'        =>    'required',
        ]);

        Auth::user()->password = bcrypt($request->input('user.password'));
        Auth::user()->api_token = str_random(60);
        Auth::user()->save();
        
        if ($request->ajax()) {
            return response()->json([
                'title'    => trans('cms.success'),
                'message'    => trans('user.update-password-success'),
                'redirect'    =>    route('admin.profile.show'),
            ], 200);
        }

        return redirect()->back();
    }
}
