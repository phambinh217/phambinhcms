@extends('Cms::layouts.default',[
	'active_admin_menu' 	=> ['ecommerce.setting', ' ecommerce.setting.customer'],
	'breadcrumbs' 			=> [
		'title'	=> ['Cài đặt', 'Khách hàng'],
		'url'	=> [route('admin.ecommerce.setting.customer')],
	],
])

@section('page_title', 'Cài đặt khách hàng')

@section('content')
	<form class="form-horizontal ajax-form" method="POST" action="{{ route('admin.ecommerce.setting.customer.update') }}">
		{{ csrf_field() }}
		{{ method_field('PUT') }}
		<div class="form-body">
			<div class="form-group">
				<label class="control-lalel col-sm-3 pull-left">
					Nhóm tài khoản khách hàng
				</label>
				<div class="col-sm-9">
					@include('Cms::components.form-select-role', [
						'roles'		=> Packages\Cms\Role::get(),
						'name' 		=> 'customer_role_id',
						'selected' 	=> $customer_role_id,
						'class' => 'width-auto',
					])
					<p class="help-block">
						Hệ thống của chúng tôi cho phép bạn tạo ra nhiều nhóm tài khoản với các quyền thực hiện khác nhau. Vì thế bạn cần phải chỉ cho hệ thống biết nhóm tài khoản nào là nhóm tài khoản khách hàng để khách hàng có các quyền thực hiện thích hợp. <br />
					</p>
				</div>
			</div>
		</div>
		<div class="form-body">
			<div class="form-group">
				<label class="control-lalel col-sm-3 pull-left">
					Bắt buộc xác nhận đơn hàng qua email
				</label>
				<div class="col-sm-9">
					<i>Xem cài đặt <a href="{{ route('admin.ecommerce.setting.order') }}">Xác nhận đơn hàng qua email</a></i>
				</div>
			</div>
		</div>
		<div class="form-actions util-btn-margin-bottom-5">
			<button class="btn btn-primary full-width-xs">
				<i class="fa fa-check"></i> Đặt là nhóm khách hàng
			</button>
		</div>
	</form>
@endsection

@push('css')
	<link href="{{ asset_url('admin', 'global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
@endpush

@push('js_footer')
	<script type="text/javascript" src="{{ asset_url('admin', 'global/plugins/jquery-form/jquery.form.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset_url('admin', 'global/plugins/bootstrap-toastr/toastr.min.js') }}"></script>
@endpush
