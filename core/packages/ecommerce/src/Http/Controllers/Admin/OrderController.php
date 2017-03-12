<?php

namespace Packages\Ecommerce\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Validator;
use Packages\Ecommerce\Order;
use AdminController;

class OrderController extends AdminController
{
    public function index()
    {
        $filter = Order::getRequestFilter();
        $orders = Order::with('customer', 'status')->applyFilter($filter)->paginate($this->paginate);
        $this->data['filter'] = $filter;
        $this->data['orders'] = $orders;

        \Metatag::set('title', 'Danh sách đơn hàng');
        return view('Ecommerce::admin.order.list', $this->data);
    }

    public function show(Order $order)
    {
        $this->data['order'] = $order;
        $this->data['order_id'] = $order->id;

        \Metatag::set('title', 'Chi tiết đơn hàng');
        return view('Ecommerce::admin.order.show', $this->data);
    }

    public function create()
    {
        
    }

    public function edit(Order $order)
    {
        $this->data['order'] = $order;
        $this->data['order_id'] = $order->id;

        \Metatag::set('title', 'Chỉnh sửa đơn hàng');
        return view('Ecommerce::admin.order.edit', $this->data);
    }

    public function changeStatus(Request $request, Order $order)
    {
        $this->validate($request, [
            'status_id' => 'required|exists:order_statuses,id'
        ]);

        $order->status_id = $request->status_id;
        $order->save();

        if ($request->ajax()) {
            return response()->json([
                'title' => trans('cms.success'),
                'message' => 'Thay đổi trạng thái thành công'
            ]);
        }

        return redirect()->back();
    }
}
