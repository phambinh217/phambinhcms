<?php

namespace Phambinh\Cms\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Validator;
use Phambinh\Cms\User;

class UserController extends AdminController
{
    public function index()
    {
        $filter = User::getRequestFilter();
        $users = User::select('users.*', 'roles.name as role_name')
            ->join('roles', 'users.role_id', '=', 'roles.id')
            ->applyFilter($filter)->paginate($this->paginate);
        
        $this->data['users']    = $users;
        $this->data['filter']   = $filter;

        \Metatag::set('title', trans('user.list-user'));
        return view('Cms::admin.user.list', $this->data);
    }

    public function show(User $user)
    {
        if ($user->isSelf()) {
            return redirect()->route('admin.profile.show');
        }
        
        $this->data['user'] = $user;
        $this->data['user_id'] = $user->id;

        \Metatag::set('title', trans('user.view-detail'));
        return view('Cms::admin.user.show', $this->data);
    }

    public function popupShow(User $user)
    {
        $this->data['user'] = $user;
        $this->data['user_id'] = $user->id;

        return view('Cms::admin.user.popup-show', $this->data);
    }
    
    public function create()
    {
        $user = new User();
        $this->data['user'] = $user;

        \Metatag::set('title', trans('user.add-new-user'));
        return view('Cms::admin.user.save', $this->data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'user.name'                    => 'required|unique:users,name',
            'user.phone'                    => 'required|unique:users,phone',
            'user.email'                    => 'required|email|max:255|unique:users,email',
            'user.last_name'                => 'required|max:255',
            'user.first_name'                => 'required|max:255',
            'user.birth'                    => 'required|date_format:d-m-Y',
            'user.password'                => 'required|confirmed',
            'user.password_confirmation'    => 'required',
            'user.role_id'                    => 'required|exists:roles,id',
            'user.status'                    => 'required|in:enable,disable',
            'user.about'                    =>    'max:500',
            'user.facebook'                    =>    'max:255',
            'user.website'                    =>    'max:255',
            'user.job'                        =>    'max:255',
            'user.google_plus'                =>    'max:255',
        ]);

        $user = new User();
        $user->fill($request->input('user'));
        $user->password = bcrypt($user->password);
        $user->api_token = str_random(60);

        $user->save();

        if ($request->ajax()) {
            return response()->json([
                'title'        =>    trans('cms.success'),
                'message'    =>    trans('user.create-user-success'),
                'redirect'    =>    $request->exists('save_only') ?
                    route('admin.user.edit', ['id' => $user->id]) :
                    route('admin.user.create'),
            ], 200);
        }

        if ($request->exists('save_only')) {
            return redirect()-route('admin.user.edit', ['id' => $user->id]);
        }

        return redirect()->route('admin.user.create');
    }

    public function edit(User $user)
    {
        if ($user->isSelf()) {
            return redirect(route('admin.profile.show'));
        }

        $this->data['user'] = $user;
        $this->data['user_id'] = $user->id;

        \Metatag::set('title', trans('user.edit-user'));
        return view('Cms::admin.user.save', $this->data);
    }

    public function update(Request $request, User $user)
    {
        if ($user->isSelf()) {
            return response()->json([
                'title' =>  trans('cms.error'),
                'message'   =>  trans('can-not-apply-yourself'),
            ], 422);
        }

        $this->validate($request, [
            'user.last_name'                => 'required|max:255',
            'user.first_name'                => 'required|max:255',
            'user.birth'                    => 'required|date_format:d-m-Y',
            'user.phone'                    => 'required|unique:users,phone,'.$user->id.',id',
            'user.email'                    => 'required|email|max:255|unique:users,email,'.$user->id.',id',
            'user.role_id'                    => 'required|exists:roles,id',
            'user.status'                    => 'required|in:enable,disable',
            'user.about'                    =>    'max:500',
            'user.facebook'                    =>    'max:255',
            'user.website'                    =>    'max:255',
            'user.job'                        =>    'max:255',
            'user.google_plus'                =>    'max:255',
        ]);

        $user->fill($request->input('user'))->save();

        if ($request->ajax()) {
            $response = [
                'title'        =>    trans('cms.success'),
                'message'    =>    trans('user.update-user-success'),
            ];

            if ($request->exists('save_and_out')) {
                $response['redirect'] = route('admin.user.index');
            }

            return response()->json($response, 200);
        }
        
        if ($request->exists('save_and_out')) {
            return redirect()->route('admin.user.index');
        }
                
        return redirect()->back();
    }

    public function disable(Request $request, User $user)
    {
        if ($user->isSelf()) {
            if ($request->ajax()) {
                return response()->json([
                    'title' =>  trans('cms.error'),
                    'message'   =>  trans('can-not-apply-yourself'),
                ], 422);
            }

            return redirect()->back();
        }

        $user->markAsDisable();

        if ($request->ajax()) {
            return response()->json([
                'title'        =>    trans('cms.success'),
                'message'    =>    trans('user.disable-user-success'),
            ], 200);
        }

        return redirect()->back();
    }

    public function enable(Request $request, User $user)
    {
        if ($user->isSelf()) {
            if ($request->ajax()) {
                return response()->json([
                    'title' =>  trans('cms.error'),
                    'message'   =>  trans('can-not-apply-yourself'),
                ], 422);
            }

            return redirect()->back();
        }

        $user->markAsEnable();

        if ($request->ajax()) {
            return response()->json([
                'title'        =>    trans('cms.success'),
                'message'    =>    trans('user.enable-user-success'),
            ], 200);
        }
        
        return redirect()->back();
    }

    public function destroy(Request $request, User $user)
    {
        if ($user->isSelf()) {
            if ($request->ajax()) {
                return response()->json([
                    'title' =>  trans('cms.error'),
                    'message'   =>  trans('can-not-apply-yourself'),
                ], 402);
            }

            return redirect()->back();
        }

        $user->delete();

        if ($request->ajax()) {
            return response()->json([
                'title'        =>    trans('cms.success'),
                'message'    =>    trans('user.destroy-user-success'),
            ], 200);
        }
        
        return redirect()->back();
    }

    public function loginAs(User $user)
    {
        \Auth::loginUsingId($user->id);

        return redirect(url('/'));
    }
}
