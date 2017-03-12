<?php

namespace Packages\Deky\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use AdminController;
use Packages\Deky\Trainer;

class TrainerController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        \Metatag::set('title', 'Danh sách giảng viên');

        $trainer = new Trainer();
        $filter = $trainer->getRequestFilter();
        $this->data['filter'] = $filter;
        $this->data['trainer'] = $trainer;
        $this->data['trainers'] = $trainer->applyFilter($filter)
            ->select('users.*')
            ->addSelect(\DB::raw('count(courses.id) as total_class'))
            ->leftjoin('courses', 'courses.trainer_id', '=', 'users.id')
            ->groupBy('users.id')
            ->paginate($this->paginate);

        return view('Trainer::admin.list', $this->data);
    }

    public function show(Trainer $trainer)
    {
        $trainer = Trainer::find($id);
        $this->data['trainer'] = $trainer;

        \Metatag::set('title', 'Xem giảng viên');
        return view('Trainer::admin.show', $this->data);
    }

    public function create()
    {
        \Metatag::set('title', 'Thêm giảng viên mới');

        $trainer = new Trainer();
        $this->data['trainer'] = $trainer;

        return view('Trainer::admin.save', $this->data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'trainer.name'                        => 'required|unique:users,name',
            'trainer.phone'                    => 'required|unique:users,phone',
            'trainer.email'                    => 'required|email|max:255|unique:users,email',
            'trainer.last_name'                => 'required|max:255',
            'trainer.first_name'                => 'required|max:255',
            'trainer.birth'                    => 'required|date_format:d-m-Y',
            'trainer.password'                    => 'required|confirmed',
            'trainer.password_confirmation'    => 'required',
            'trainer.address'                    => 'max:300',
            'trainer.status'                    => 'required|in:0,1',
        ]);

        $trainer = new Trainer();
        $trainer->fill($request->trainer);
        $trainer->birth = changeFormatDate($trainer->birth, 'd-m-Y', 'Y-m-d');
        $trainer->password = bcrypt($trainer->password);
        $trainer->role_id = setting('trainer_role_id');

        $trainer->save();

        if ($request->ajax()) {
            return response()->json([
                'title'        =>    trans('cms.success'),
                'message'    =>    'Đã thêm giảng viên mới',
                'redirect'    =>    $request->exists('save_only') ?
                    route('admin.trainer.edit', ['id' => $trainer->id]) :
                    route('admin.trainer.create'),
            ], 200);
        }

        if ($request->exists('save_only')) {
            return redirect()->route('admin.trainer.edit', ['id' => $trainer->id]);
        }

        return redirect()->route('admin.trainer.create');
    }

    public function edit(Trainer $trainer)
    {
        $trainer = Trainer::find($id);

        $this->data['trainer_id'] = $trainer->id;
        $this->data['trainer'] = $trainer;

        \Metatag::set('title', 'Chỉnh sửa giảng viên');
        return view('Trainer::admin.save', $this->data);
    }

    public function update(Request $request, Trainer $trainer)
    {
        $this->validate($request, [
            'trainer.last_name'                => 'required|max:255',
            'trainer.first_name'                => 'required|max:255',
            'trainer.birth'                    => 'required|date_format:d-m-Y',
            'trainer.phone'                    => 'required|unique:users,phone,'.$trainer->id.',id',
            'trainer.email'                    => 'required|email|max:255|unique:users,email,'.$trainer->id.',id',
            'trainer.status'                    => 'required|in:0,1',
            'trainer.address'                    => 'max:300',
        ]);

        $trainer->fill($request->trainer);
        $trainer->birth = changeFormatDate($trainer->birth, 'd-m-Y', 'Y-m-d');
        $trainer->save();

        if ($request->ajax()) {
            $response = [
                'title'        =>    trans('cms.success'),
                'message'    =>    'Đã cập nhật thông tin',
            ];
            if ($request->exists('save_and_out')) {
                $response['redirect'] = route('admin.trainer.index');
            }

            return response()->json($response, 200);
        }
        
        if ($request->exists('save_and_out')) {
            return redirect()->route('admin.trainer.index');
        }
                
        return redirect()->back();
    }

    public function disable(Request $request, Trainer $trainer)
    {
        $trainer->status = '0';
        $trainer->save();

        if ($request->ajax()) {
            return response()->json([
                'title'        =>    trans('cms.success'),
                'message'    =>    'Đã ẩn giảng viên',
            ], 200);
        }

        return redirect()->back();
    }

    public function enable(Request $request, Trainer $trainer)
    {
        $trainer->status = '1';
        $trainer->save();

        if ($request->ajax()) {
            return response()->json([
                'title'        =>    trans('cms.success'),
                'message'    =>    'Đã kích hoạt giảng viên',
            ], 200);
        }
        
        return redirect()->back();
    }

    public function destroy(Request $request, Trainer $trainer)
    {
        if ($trainer->students()->count() || $trainer->courses()->count()) {
            if ($request->ajax()) {
                return response()->json([
                    'title'        =>    trans('cms.error'),
                    'message'    =>    'Người này có dữ liệu trong hệ thống'
                ], 402);
            }

            return redirect()->back();
        }

        $trainer->delete();

        if ($request->ajax()) {
            return response()->json([
                'title'        =>    trans('cms.success'),
                'message'    =>    'Đã xóa giảng viên',
            ], 200);
        }
        
        return redirect()->back();
    }
}
