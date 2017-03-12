<?php

namespace Packages\Deky\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Packages\Deky\StudentGroup;
use AdminController;
use Validator;

class GroupController extends AdminController
{
    public function index()
    {
        $group = new StudentGroup();
        $filter = $group->getRequestFilter();
        $this->data['group']    = $group;
        $this->data['groups']    = $group->applyFilter($filter)->paginate($this->paginate);
        $this->data['filter'] = $filter;

        return view('Deky::admin.student.group.list', $this->data);
    }

    public function create()
    {
        $this->data['group'] = new StudentGroup();
        return view('Deky::admin.student.group.save', $this->data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'group.title'        => 'required|max:255',
            'group.slug'            => 'max:255',
            'group.description'    => 'max:300',
        ]);

        $group = new StudentGroup();
        $group->fill($request->group);
        if (empty($group->slug)) {
            $group->slug = str_slug($group->title);
        }
        $group->save();

        if ($request->ajax()) {
            return response()->json([
                'title'        =>    trans('cms.success'),
                'message'    =>    trans('cms.success'),
                'redirect'    =>    $request->exists('save_only') ?
                    route('admin.student.group.edit', ['id' => $group->id]) :
                    route('admin.student.group.create'),
            ]);
        }
        
        if ($request->exists('save_only')) {
            return redirect()->route('admin.student.group.edit', ['id' => $group->id]);
        }

        return redirect()->route('admin.student.group.create');
    }

    public function edit(Group $group)
    {
        $this->data['group'] = $group;
        $this->data['group_id'] = $group->id;

        return view('Deky::admin.student.group.save', $this->data);
    }

    public function update(Request $request, Group $group)
    {
        $this->validate($request, [
            'group.title'        => 'required|max:255',
            'group.slug'            => 'max:255',
            'group.description'    => 'max:300',
        ]);

        $group->fill($request->group);
        if (empty($group->slug)) {
            $group->slug = str_slug($group->title);
        }
        $group->save();

        if ($request->ajax()) {
            $response = [
                'title'        =>    trans('cms.success'),
                'message'    =>    trans('cms.success'),
            ];
            if ($request->exists('save_and_out')) {
                $response['redirect'] = route('admin.student.group.index');
            }

            return response()->json($response, 200);
        }
        
        if ($request->exists('save_and_out')) {
            return redirect(route('admin.student.group.index'));
        }

        return redirect()->back();
    }

    public function destroy(Request $request, Group $group)
    {
        if ($group->students->count()) {
            if ($request->ajax()) {
                return response()->json([
                    'title'        =>    trans('cms.error'),
                    'message'    =>    'Nhóm này đã có học viên',
                ], 422);
            }
            
            return redirect()->back();
        }

        $group->delete();
        
        if ($request->ajax()) {
            return response()->json([
                'title'            =>    trans('cms.success'),
                'message'        =>    'Đã xóa',
            ], 200);
        }

        return redirect()->back();
    }
}
