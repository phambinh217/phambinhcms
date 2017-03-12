<?php 

namespace Packages\Ecommerce\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Validator;
use AdminController;
use Packages\Ecommerce\Customer;

class CustomerController extends AdminController
{
    public function index()
    {
        $filter = Customer::getRequestFilter();
        $customers = Customer::select('users.*', 'roles.name as role_name')
            ->join('roles', 'users.role_id', '=', 'roles.id')
            ->applyFilter($filter)->paginate($this->paginate);
        
        $this->data['customers']    = $customers;
        $this->data['filter']       = $filter;

        \Metatag::set('title', 'Danh sách khách hàng');
        return view('Ecommerce::admin.customer.list', $this->data);
    }

    public function show(Customer $customer)
    {
        \Metatag::set('title', 'Xem chi tiết khách hàng');

        $this->data['customer'] = $customer;
        $this->data['customer_id'] = $customer->id;

        return view('Ecommerce::admin.customer.show', $this->data);
    }

    public function popupShow(Customer $customer)
    {
        $this->data['customer'] = $customer;
        $this->data['customer_id'] = $customer->id;

        return view('Ecommerce::admin.customer.popup-show', $this->data);
    }
    
    public function create()
    {
        \Metatag::set('title', 'Thêm khách hàng');

        $customer = new Customer();
        $this->data['customer'] = $customer;
        return view('Ecommerce::admin.customer.save', $this->data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'customer.name'                    => 'required|unique:users,name',
            'customer.phone'                    => 'required|unique:users,phone',
            'customer.email'                    => 'required|email|max:255|unique:users,email',
            'customer.last_name'                => 'required|max:255',
            'customer.first_name'                => 'required|max:255',
            'customer.birth'                    => 'required|date_format:d-m-Y',
            'customer.password'                => 'required|confirmed',
            'customer.password_confirmation'    => 'required',
            'customer.role_id'                    => 'required|exists:roles,id',
            'customer.status'                    => 'required|in:enable,disable',
            'customer.about'                    =>    'max:500',
            'customer.facebook'                    =>    'max:255',
            'customer.website'                    =>    'max:255',
            'customer.job'                        =>    'max:255',
            'customer.google_plus'                =>    'max:255',
        ]);

        $customer = new Customer();
        $customer->fill($request->customer);
        $customer->birth = changeFormatDate($customer->birth, 'd-m-Y', 'Y-m-d');
        $customer->password = bcrypt($customer->password);
        
        switch ($user->status) {
            case 'disable':
                $user->status = '0';
                break;

            case 'enable':
                $user->status = '1';
                break;
        }

        $customer->save();

        if ($request->ajax()) {
            return response()->json([
                'title'        =>    trans('cms.success'),
                'message'    =>    'Đã thêm khách hàng mới',
                'redirect'    =>    $request->exists('save_only') ?
                    route('admin.ecommerce.customer.edit', ['id' => $customer->id]) :
                    route('admin.ecommerce.customer.create'),
            ], 200);
        }

        if ($request->exists('save_only')) {
            return redirect()->route('admin.ecommerce.customer.edit', ['id' => $customer->id]);
        }

        return redirect()->route('admin.ecommerce.customer.create');
    }

    public function edit(Customer $customer)
    {
        \Metatag::set('title', 'Chỉnh sửa khách hàng');
        
        // Không thể tự chỉnh sửa thông tin của bản thân trong phương thức này
        // Sẽ tự đi vào trang cá nhân
        if ($customer->isSelf()) {
            return redirect()->route('admin.profile');
        }

        $this->data['customer'] = $customer;
        $this->data['customer_id'] = $customer->id;

        return view('Ecommerce::admin.customer.save', $this->data);
    }

    public function update(Request $request, Customer $customer)
    {
        if ($customer->isSelf()) {
            return response()->json([], 422);
        }

        $this->validate($request, [
            'customer.last_name'                => 'required|max:255',
            'customer.first_name'                => 'required|max:255',
            'customer.birth'                    => 'required|date_format:d-m-Y',
            'customer.phone'                    => 'required|unique:users,phone,'.$customer->id.',id',
            'customer.email'                    => 'required|email|max:255|unique:users,email,'.$customer->id.',id',
            'customer.role_id'                    => 'required|exists:roles,id',
            'customer.status'                    => 'required|in:enable,disable',
            'customer.about'                    =>    'max:500',
            'customer.facebook'                    =>    'max:255',
            'customer.website'                    =>    'max:255',
            'customer.job'                        =>    'max:255',
            'customer.google_plus'                =>    'max:255',
        ]);

        $customer->fill($request->customer);
        $customer->birth = changeFormatDate($customer->birth, 'd-m-Y', 'Y-m-d');
        
        switch ($user->status) {
            case 'disable':
                $user->status = '0';
                break;

            case 'enable':
                $user->status = '1';
                break;
        }

        $customer->save();

        if ($request->ajax()) {
            $response = [
                'title'        =>    trans('cms.success'),
                'message'    =>    'Đã cập nhật thông tin khách hàng',
            ];
            if ($request->exists('save_and_out')) {
                $response['redirect'] = route('admin.ecommerce.customer.index');
            }

            return response()->json($response, 200);
        }
        
        if ($request->exists('save_and_out')) {
            return redirect()->route('admin.ecommerce.customer.index');
        }
                
        return redirect()->back();
    }

    public function disable(Request $request, Customer $customer)
    {
        if ($customer->isSelf()) {
            if ($request->ajax()) {
                return response()->json([

                ], 422);
            }

            return redirect()->back();
        }

        $customer->status = '0';
        $customer->save();

        if ($request->ajax()) {
            return response()->json([
                'title'        =>    trans('cms.success'),
                'message'    =>    trans('cms.success'),
            ], 200);
        }

        return redirect()->back();
    }

    public function enable(Request $request, Customer $customer)
    {
        if ($customer->isSelf()) {
            if ($request->ajax()) {
                return response()->json([

                ], 422);
            }

            return redirect()->back();
        }

        $customer->status = '1';
        $customer->save();

        if ($request->ajax()) {
            return response()->json([
                'title'        =>    trans('cms.success'),
                'message'    =>    trans('cms.success'),
            ], 200);
        }
        
        return redirect()->back();
    }

    public function destroy(Request $request, Customer $customer)
    {
        if ($customer->isSelf()) {
            if ($request->ajax()) {
                return response()->json([

                ], 402);
            }

            return redirect()->back();
        }

        if ($customer->orders->count()) {
            if ($request->ajax()) {
                return response()->json([
                    'title'        =>    'Không thể xóa',
                    'message'    =>    'Người này có dữ liệu trong hệ thống'
                ], 402);
            }

            return redirect()->back();
        }

        $customer->delete();

        if ($request->ajax()) {
            return response()->json([
                'title'        =>    trans('cms.success'),
                'message'    =>    'Đã xóa khách hàng',
            ], 200);
        }
        
        return redirect()->back();
    }
}
