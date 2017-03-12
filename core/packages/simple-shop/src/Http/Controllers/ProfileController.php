<?php

namespace Packages\SimpleShop\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Packages\Ecommerce\Order;
use HomeController as CoreHomeController;

class ProfileController extends CoreHomeController
{
    public function __construct()
    {
        $this->middleware('auth');
        parent::__construct();
    }

    public function index()
    {
        \Metatag::set('title', 'Trang cá nhân');
        return view('Home::profile.index', $this->data);
    }

    public function changePassword()
    {
        \Metatag::set('title', 'Đổi mật khẩu');
        return view('Home::profile.change-password', $this->data);
    }

    public function edit()
    {
        \Metatag::set('title', 'Chỉnh sửa thông tin cá nhân');
        return view('Home::profile.edit', $this->data);
    }

    public function historyOrder()
    {
        $orders = Order::with('status', 'products')->paginate(10);
        $this->data['orders'] = $orders;

        \Metatag::set('title', 'Lịch sử đơn hàng');
        return view('Home::profile.history-order', $this->data);
    }

    public function requestReturn()
    {
        \Metatag::set('title', 'Yêu cầu trả lại');
        return view('Home::profile.request-return', $this->data);
    }

    public function updatePassword(Request $request)
    {
        $this->validate($request, [
            'user.old_passowrd' =>'required|hash:' . \Auth::user()->password,
            'user.password' => 'required|confirmed',
            'user.password_confirmation' => 'required',
        ]);

        \Auth::user()->password = bcrypt($request->user['password']);
        \Auth::user()->save();
        
        if ($request->ajax()) {
            return response()->json([
                'title' => trans('cms.success'),
                'message' => 'Đã đổi mật khẩu thành công',
            ], 200);
        }

        return redirect()->back();
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'user.first_name' => 'required|max:255',
            'user.last_name' => 'required|max:255',
            'user.birth'        =>  'required|date_format:d-m-Y',
            'user.phone'        =>    'max:255',
            'user.about'        =>    'max:500',
            'user.facebook'        =>    'max:255',
            'user.website'        =>    'max:255',
            'user.job'            =>    'max:255',
            'user.google_plus'    =>    'max:255',
        ]);

        \Auth::user()->fill($request->user);
        \Auth::user()->birth = changeFormatDate($request->user['birth'], 'd-m-Y', 'Y-m-d');
        \Auth::user()->save();

        if ($request->ajax()) {
            return response()->json([
                'title' => trans('cms.success'),
                'message' => 'Đã cập nhật thông tin cá nhân',
            ], 200);
        }

        return redirect()->back()->with('message-success', 'Đã cập nhật thông tin cá nhân');
    }
}
