<?php

namespace Packages\Cms\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Validator;
use Packages\Cms\User;
use Packages\Cms\Role;
use Packages\Cms\Permission;

class RoleController extends AdminController
{
    public function index()
    {
        $filter = Role::getRequestFilter();
        $roles = Role::applyFilter($filter)
            ->select('roles.*')
            ->addSelect(\DB::raw('count(users.id) as total_user'))
            ->leftjoin('users', 'users.role_id', '=', 'roles.id')
            ->groupBy('roles.id')
            ->paginate($this->paginate);

        $this->data['roles'] = $roles;
        $this->data['filter'] = $filter;

        \Metatag::set('title', trans('role.list-role'));
        return view('Cms::admin.role.list', $this->data);
    }

    public function create()
    {
        $role = new Role();
        $this->data['role'] = $role;

        \Metatag::set('title', trans('role.add-new-role'));
        return view('Cms::admin.role.save', $this->data);
    }

    public function edit(Role $role)
    {
        $this->data['role'] = $role;
        $this->data['role_id'] = $role->id;

        \Metatag::set('title', trans('role.edit-role'));
        return view('Cms::admin.role.save', $this->data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'role.name'    =>    'required',
            'role.type'    =>    'required|in:0,*,option',
            'role.permission' => 'required_if:role.type,option',
        ]);

        \AccessControl::forgetCache();

        $role = new Role();
        $role->fill($request->role)->save();

        if ($role->isOption()) {
            $permissions = [];
            if ($request->has('role.permission')) {
                foreach ($request->input('role.permission') as $perm) {
                    $permissions[] = new Permission(['permission' => $perm]);
                }
            }
            $role->permissions()->saveMany($permissions);
        }

        if ($request->ajax()) {
            return response()->json([
                'title'        =>    trans('cms.success'),
                'message'    =>    trans('role.create-role-success'),
                'redirect'    =>    $request->exists('save_only') ?
                    route('admin.role.edit', ['id' => $role->id]) :
                    route('admin.role.create'),
            ], 200);
        }

        if ($request->exists('save_only')) {
            return redirect()->route('admin.role.edit', ['id' => $role->id]);
        }

        return redirect()->route('admin.role.create');
    }

    public function update(Request $request, Role $role)
    {
        $this->validate($request, [
            'role.name'    =>    'required',
            'role.type'    =>    'required|in:0,*,option',
            'role.permission' => 'required_if:role.type,option',
        ]);

        \AccessControl::forgetCache();
        
        $role->fill($request->role)->save();
        
        $role->permissions()->delete();

        if ($role->isOption()) {
            $permissions = [];
            if ($request->has('role.permission')) {
                foreach ($request->input('role.permission') as $perm) {
                    $permissions[] = new Permission(['permission' => $perm]);
                }
            }
            $role->permissions()->saveMany($permissions);
        }

        if ($request->ajax()) {
            $response = [
                'title'        =>    trans('cms.success'),
                'message'    =>    trans('role.update-role-success'),
            ];
            if ($request->exists('save_and_out')) {
                $response['redirect'] = route('admin.role.index');
            }

            return response()->json($response, 200);
        }
        
        if ($request->exists('save_and_out')) {
            return redirect()->route('admin.role.index');
        }
                
        return redirect()->back();
    }

    public function destroy(Request $request, Role $role)
    {
        if ($role->users->count()) {
            if ($request->ajax()) {
                return response()->json([
                    'title'        =>    trans('cms.error'),
                    'message'    =>    trans('role.role-has-user')
                ], 402);
            }

            return redirect()->back();
        }

        $role->delete();

        if ($request->ajax()) {
            return response()->json([
                'title'        =>    trans('cms.success'),
                'message'    =>    trans('role.destroy-role-success'),
            ], 200);
        }
        
        return redirect()->back();
    }
}
