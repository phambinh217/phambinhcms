<?php

namespace Packages\Ecommerce\Http\Controllers\Admin;

use Illuminate\Http\Request;
use AdminController;
use Validator;
use Packages\Ecommerce\Currency;
use Packages\Ecommerce\OrderStatus;
use Packages\Cms\Role;

class SettingController extends AdminController
{
    public function currency()
    {
        $currencies = Currency::get();
        $default_currency_id = setting('default-currency-id');
        $this->data['currencies'] = $currencies;
        $this->data['currency'] = $currencies->where('id', $default_currency_id)->first();
        $this->data['default_currency_id'] = $default_currency_id;

        \Metatag::set('title', 'Cài đặt tiền tệ');
        return view('Ecommerce::admin.setting.currency', $this->data);
    }

    public function currencySettingUpdate(Request $request)
    {
        $this->validate($request, [
            'default_currency_id' => 'required|integer|exists:currencies,id'
        ]);

        $currency = Currency::find($request->input('default_currency_id'));

        setting()->sync('currency', $currency->toArray());
        setting()->sync('default-currency-id', $currency->id);

        if ($request->ajax()) {
            return response()->json([
                'title' => trans('cms.success'),
                'message' => 'Đã cập nhật đơn vị tiền tệ mặc định',
            ]);
        }

        return redirect()->back();
    }

    public function currencyStore(Request $request)
    {
        $this->validate($request, [
            'currency.name' => 'required',
            'currency.code' => 'required',
            'currency.symbol_left' => '',
            'currency.symbol_right' => '',
            'currency.decimal_place' => '',
        ]);

        $currency = new Currency();
        $currency->fill($request->input('currency'))->save();

        if ($request->ajax()) {
            return response()->json([
                'title' => trans('cms.success'),
                'message' => 'Đã thêm đơn vị tiền tệ mới',
                'redirect' => route('admin.ecommerce.setting.currency'),
            ]);
        }

        return redirect()->back();
    }

    public function currencyUpdate(Request $request, Currency $currency)
    {
        $this->validate($request, [
            'currency.name' => 'required',
            'currency.code' => 'required',
            'currency.symbol_left' => '',
            'currency.symbol_right' => '',
            'currency.decimal_place' => '',
        ]);

        $currency->fill($request->input('currency'))->save();

        if ($request->ajax()) {
            return response()->json([
                'title' => trans('cms.success'),
                'message' => 'Đã cập nhật đơn vị tiền tệ',
            ]);
        }

        return redirect()->back();
    }

    public function currencyDestroy(Request $request, Currency $currency)
    {
        if (setting('default-currency-id') == $id) {
            if ($request->ajax()) {
                return response()->json([
                    'title' => trans('cms.error'),
                    'message' => 'Đơn vị này được cài đặt',
                ], 422);
            }
            return redirect()->back();
        }

        $currency->delete();

        if ($request->ajax()) {
            return response()->json([
                'title'            =>    trans('cms.success'),
                'message'        =>    'Đã xóa',
                'redirect' => route('admin.ecommerce.setting.currency'),
            ], 200);
        }

        return redirect()->back();
    }

    public function customer()
    {
        $this->data['roles'] = Role::get();
        $this->data['customer_role_id'] = setting('customer-role-id');

        \Metatag::set('title', 'Cài đặt khách hàng');
        return view('Ecommerce::admin.setting.customer', $this->data);
    }

    public function customerUpdate(Request $request)
    {
         $this->validate($request, [
            'customer_role_id' => 'required|integer|exists:roles,id',
        ]);
        
        setting()->sync('customer-role-id', $request->input('customer_role_id'));

        if ($request->ajax()) {
            return response()->json([
                'title' => trans('cms.success'),
                'message' => 'Đã cập nhật nhóm khách hàng',
            ]);
        }

        return redirect()->back();
    }

    public function order()
    {
        $order_statuses = OrderStatus::get();
        $default_order_status_id = setting('default-order-status-id');

        $this->data['order_notify_email_to'] = setting('order-notify-email-to', setting('company-email'));
        $this->data['confirm_order'] = setting('confirm-order');
        $this->data['order_notify_email'] = setting('order-notify-email');
        $this->data['order_status_not_confirm'] = setting('order-status-not-confirm');
        $this->data['default_order_status_id'] = $default_order_status_id;
        $this->data['order_statuses'] = $order_statuses;
        $this->data['order_status'] = $order_statuses->where('id', $default_order_status_id)->first();

        \Metatag::set('title', 'Cài đặt đơn hàng');
        return view('Ecommerce::admin.setting.order', $this->data);
    }

    public function orderStatusStore(Request $request)
    {
        $this->validate($request, [
            'order_status.name' => 'required',
            'order_status.comment' => ''
        ]);

        $order_status = new OrderStatus();
        $order_status->fill($request->input('order_status'))->save();

        if ($request->ajax()) {
            return response()->json([
                'title' => trans('cms.success'),
                'message' => 'Đã thêm trạng thái đơn hàng mới',
                'redirect' => route('admin.ecommerce.setting.order'),
            ]);
        }

        return redirect()->back();
    }

    public function orderStatusUpdate(Request $request, OrderStatus $order_status)
    {
        $this->validate($request, [
            'order_status.name' => 'required',
            'order_status.comment' => ''
        ]);

        $order_status->fill($request->input('order_status'))->save();

        if ($request->ajax()) {
            return response()->json([
                'title' => trans('cms.success'),
                'message' => 'Đã cập nhật trạng thái đơn hàng',
                'redirect' => route('admin.ecommerce.setting.order'),
            ]);
        }

        return redirect()->back();
    }

    public function orderStatusDestroy(Request $request, OrderStatus $orderStatus)
    {
        if ($orderStatus->orders()->count()) {
            if ($request->ajax()) {
                return response()->json([
                    'title' => trans('cms.error'),
                    'message' => 'Trạng thái này đã có đơn hàng',
                ], 422);
            }
            return redirect()->back();
        }

        if (setting('default-order-status-id') == $id || setting('order-status-not-confirm') == $id) {
            if ($request->ajax()) {
                return response()->json([
                    'title' => trans('cms.error'),
                    'message' => 'Trạng thái này được cài đặt',
                ], 422);
            }
            return redirect()->back();   
        }

        $orderStatus->delete();

        if ($request->ajax()) {
            return response()->json([
                'title'            =>    trans('cms.success'),
                'message'        =>    trans('cms.success'),
                'redirect' => route('admin.ecommerce.setting.order'),
            ], 200);
        }

        return redirect()->back();
    }

    public function orderSettingUpdate(Request $request)
    {
        $this->validate($request, [
            'confirm_order' => 'required|in:true,false',
            'order_status_not_confirm' => 'required_if:confirm_order,true|integer|exists:order_statuses,id',
            'order_notify_email' => 'required|in:true,false',
            'order_notify_email_to' => 'required_if:order_notify_email,true|email',
            'default_order_status_id' => 'required|integer|exists:order_statuses,id',
        ]);

        setting()->sync('confirm-order', $request->input('confirm_order'));
        setting()->sync('order-status-not-confirm', $request->input('order_status_not_confirm'));
        setting()->sync('order-notify-email', $request->input('order_notify_email'));
        setting()->sync('order-notify-email-to', $request->input('order_notify_email_to'));
        setting()->sync('default-order-status-id', $request->input('default_order_status_id'));

        if ($request->ajax()) {
            return response()->json([
                'title' => trans('cms.success'),
                'message' => 'Đã lưu cài đặt đơn hàng',
            ]);
        }

        return redirect()->back();
    }
}
