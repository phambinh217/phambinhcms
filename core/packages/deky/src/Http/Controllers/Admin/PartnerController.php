<?php

namespace Packages\Deky\Http\Controllers\Admin;

use Illuminate\Http\Request;
use AdminController;
use Packages\Deky\Partner;

class PartnerController extends AdminController
{
    /**
     * Hiển thị trang danh sách cộng tác viên
     */
    public function index()
    {
        \Metatag::set('title', 'Danh sách cộng tác viên');

        $partner = new Partner();
        $filter = $partner->getRequestFilter();
        $this->data['filter'] = $filter;
        $this->data['partner'] = $partner;
        $this->data['partners'] = $partner->applyFilter($filter)
            ->select('users.*')
            ->addSelect(\DB::raw('count(classes.id) as total_student'))
            ->leftJoin('classes', 'users.id', '=', 'classes.user_intro_id')
            ->groupBy('users.id')
            ->paginate($this->paginate);

        return view('Partner::admin.list', $this->data);
    }

    public function show(Partner $partner)
    {
        $this->data['partner'] = $partner;

        \Metatag::set('title', 'Xem chi tiết cộng tác viên');
        return view('Partner::admin.show', $this->data);
    }

    public function create()
    {
        $partner = new Partner();
        $this->data['partner'] = $partner;

        \Metatag::set('title', 'Thêm cộng tác viên mới');
        return view('Partner::admin.save', $this->data);
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'partner.name'                        => 'required|unique:users,name',
            'partner.phone'                    => 'required|unique:users,phone',
            'partner.email'                    => 'required|email|max:255|unique:users,email',
            'partner.last_name'                => 'required|max:255',
            'partner.first_name'                => 'required|max:255',
            'partner.birth'                    => 'required|date_format:d-m-Y',
            'partner.password'                    => 'required|confirmed',
            'partner.password_confirmation'    => 'required',
            'partner.address'                    => 'max:300',
            'partner.status'                    => 'required|in:0,1',
        ]);

        $partner = new Partner();
        $partner->fill($request->partner);
        $partner->birth = changeFormatDate($partner->birth, 'd-m-Y', 'Y-m-d');
        $partner->password = bcrypt($partner->password);
        $partner->role_id = setting('partner_role_id');

        $partner->save();

        if ($request->ajax()) {
            return response()->json([
                'title'        =>    trans('cms.success'),
                'message'    =>    'Đã thêm cộng tác viên mới',
                'redirect'    =>    $request->exists('save_only') ?
                    route('admin.partner.edit', ['id' => $partner->id]) :
                    route('admin.partner.create', ['id' => $partner_item->id]),
            ], 200);
        }

        if ($request->exists('save_only')) {
            return redirect(route('admin.partner.edit', ['id' => $partner->id]));
        }

        return redirect(route('admin.partner.create', ['id' => $partner_item->id]));
    }

    public function edit(Partner $partner)
    {
        $this->data['partner_id'] = $partner->id;
        $this->data['partner'] = $partner;

        \Metatag::set('title', 'Chỉnh sửa cộng tác viên');
        return view('Partner::admin.save', $this->data);
    }

    public function update(Request $request, Partner $partner)
    {
        $this->validate($request, [
            'partner.last_name'                => 'required|max:255',
            'partner.first_name'                => 'required|max:255',
            'partner.birth'                    => 'required|date_format:d-m-Y',
            'partner.phone'                    => 'required|unique:users,phone,'.$partner->id.',id',
            'partner.email'                    => 'required|email|max:255|unique:users,email,'.$partner->id.',id',
            'partner.status'                    => 'required|in:0,1',
            'partner.address'                    => 'max:300',
        ]);

        $partner->fill($request->partner);
        $partner->birth = changeFormatDate($partner->birth, 'd-m-Y', 'Y-m-d');
        $partner->save();

        if ($request->ajax()) {
            $response = [
                'title'        =>    trans('cms.success'),
                'message'    =>    'Đã cập nhật thông tin',
            ];
            if ($request->exists('save_and_out')) {
                $response['redirect'] = route('admin.partner.index');
            }

            return response()->json($response, 200);
        }
        
        if ($request->exists('save_and_out')) {
            return redirect()->route('admin.partner.index');
        }
                
        return redirect()->back();
    }

    public function disable(Request $request, Partner $partner)
    {
        $partner->status = '0';
        $partner->save();

        if ($request->ajax()) {
            return response()->json([
                'title'         =>    trans('cms.success'),
                'message'       =>    'Đã cấm cộng tác viên',
            ], 200);
        }

        return redirect()->back();
    }

    public function enable(Request $request, Partner $partner)
    {
        $partner->status = '1';
        $partner->save();

        if ($request->ajax()) {
            return response()->json([
                'title'        =>    trans('cms.success'),
                'message'    =>    'Đã kích hoạt cộng tác viên',
            ], 200);
        }
        
        return redirect()->back();
    }

    public function destroy(Request $request, Partner $partner)
    {
        if ($partner->students()->count()) {
            if ($request->ajax()) {
                return response()->json([
                    'title'        =>    trans('cms.error'),
                    'message'    =>    'Người này có học viên trong hệ thống'
                ], 402);
            }

            return redirect()->back();
        }

        $partner->delete();

        if ($request->ajax()) {
            return response()->json([
                'title'        =>    trans('cms.success'),
                'message'    =>    'Đã xóa cộng tác viên',
            ], 200);
        }
        
        return redirect()->back();
    }
}
