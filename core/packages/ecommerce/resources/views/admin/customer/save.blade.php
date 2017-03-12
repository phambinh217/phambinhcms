@extends('Cms::layouts.default',[
	'active_admin_menu' 	=> ['customer', isset($customer_id) ? 'customer.all' : 'customer.create'],
	'breadcrumbs' 			=> [
		'title'	=> ['Khách hàng', isset($customer_id) ? trans('cms.edit') : trans('cms.add-new')],
		'url'	=> [
			route('admin.ecommerce.customer.index'),
			route('admin.ecommerce.customer.index'),
		],
	],
])

@section('page_title', isset($customer_id) ? 'Chỉnh sửa khách hàng' : 'Thêm khách hàng mới')

@if(isset($customer_id))
	@section('page_sub_title', $customer->full_name)
	@section('tool_bar')
		@can('admin.ecommerce.customer.create')
			<a href="{{ route('admin.ecommerce.customer.create') }}" class="btn btn-primary">
				<i class="fa fa-plus"></i> <span class="hidden-xs">Thêm khách hàng mới</span>
			</a>
		@endcan
	@endsection
@endif

@section('content')
	<form action="{{ isset($customer_id) ? route('admin.ecommerce.customer.update', ['id' => $customer_id])  : route('admin.ecommerce.customer.store') }}" method="post" class="form-horizontal form-bordered form-row-stripped ajax-form">
		@if(isset($customer_id))
			<input type="hidden" name="_method" value="PUT" />
		@endif
		{{ csrf_field() }}
		<div class="form-body">
			<div class="form-group">
				<label class="control-label col-sm-3 pull-left">
					Họ và tên đệm <span class="required">*</span>
				</label>
				<div class="col-sm-7">
					<input value="{{ $customer->last_name or '' }}" name="customer[last_name]" type="text" placeholder="" class="form-control">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3 pull-left">
					Tên thật <span class="required">*</span>
				</label>
				<div class="col-sm-7">
					<input value="{{ $customer->first_name or '' }}" name="customer[first_name]" type="text" placeholder="" class="form-control">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3 pull-left">
					Bí danh <span class="required">*</span>
				</label>
				<div class="col-sm-7">
					<input value="{{ $customer->name or '' }}"  name="customer[name]" type="text" placeholder="" class="form-control" />
					<span class="help-block"> Một tên ngắn gọn, không bao gồm dấu cách và các ký tự đặc biệt </span>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3 pull-left">
					Số điện thoại <span class="required">*</span>
				</label>
				<div class="col-sm-7">
					<input value="{{ $customer->phone or '' }}" name="customer[phone]" type="text" placeholder="" class="form-control">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3 pull-left">Ngày sinh</label>
				<div class="col-sm-7">
					<input value="{{ isset($customer_id) ? changeFormatDate($customer->birth, 'Y-m-d', 'd-m-Y') : '' }}" name="customer[birth]" type="text" class="form-control" placeholder="Ví dụ: 21-07-1996">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3 pull-left">
					Địa chỉ email <span class="required">*</span>
				</label>
				<div class="col-sm-7">
					<input value="{{ $customer->email or '' }}" name="customer[email]" type="text" placeholder="" class="form-control">
					<span class="help-block"> Địa chỉ email sẽ dùng để đăng nhập tài khoản </span>
				</div>
			</div>
			
			<div class="form-group">
                <label class="control-label col-sm-3">Giới thiệu</label>
                <div class="col-sm-7">
                    <textarea name="customer[about]" class="form-control" rows="3" placeholder="">{{ $customer->about }}</textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3">Facebook</label>
                <div class="col-sm-7">
                    <input name="customer[facebook]" value="{{ $customer->facebook }}" type="text" placeholder="fb.com/xxx" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3">Google plus</label>
                <div class="col-sm-7">
                    <input name="customer[google_plus]" value="{{ $customer->google_plus }}" type="text" placeholder="" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3">Website Url</label>
                <div class="col-sm-7">
                    <input name="customer[website]" value="{{ $customer->website }}" type="text" placeholder="google.com" class="form-control">
                </div>
            </div>

			@if(! isset($customer_id))
				<div class="form-group">
					<label class="control-label col-sm-3 pull-left">
						Mật khẩu <span class="required">*</span>
					</label>
					<div class="col-sm-7">
						<input name="customer[password]" type="password" placeholder="" class="form-control">
						<span class="help-block"> Mật khẩu này sử dụng để đăng nhập tài khoản </span>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-3 pull-left">
						Xác nhận mật khẩu <span class="required">*</span>
					</label>
					<div class="col-sm-7">
						<input name="customer[password_confirmation]" type="password" placeholder="" class="form-control">
						<span class="help-block"> Xác nhận lại mật khẩu </span>
					</div>
					<div class="col-sm-2">
						<div class="mt-checkbox-list">
							<label class="mt-checkbox mt-checkbox-outline"> Hiển thị mật khẩu
								<input type="checkbox" name="test" view-password />
								<span></span>
							</label>
						</div>
					</div>
				</div>
			@endif
			
			<div class="form-group media-box-group">
                <label class="control-label col-md-3">Tải lên ảnh đại diện</label>
                <div class="col-sm-7">
                    {!! Form::btnMediaBox('customer[avatar]', $customer->avatar, thumbnail_url($customer->avatar, ['width' => '100', 'height' => '100'])) !!}
                </div>
            </div>

			<div class="form-group last">
				<label class="control-label col-sm-3 pull-left">
					Quyền quản trị <span class="required">*</span>
				</label>
				<div class="col-sm-7">
					@include('Cms::components.form-select-role', [
						'roles' 	=> Packages\Cms\Role::get(),
						'name'		=> 'customer[role_id]',
						'selected' 	=> isset($customer_id) ? $customer->role_id : NULL,
						'class'		=> 'width-auto',
					])
				</div>
			</div>

			<div class="form-group last">
				<label class="control-label col-sm-3 pull-left">
					Trạng thái <span class="required">*</span>
				</label>
				<div class="col-sm-7">
					@include('Cms::components.form-select-status', [
						'status'	=> \Packages\Cms\User::statusable()->all(),
						'name' 		=> 'customer[status]',
						'class'		=> 'width-auto',
						'selected' 	=> isset($customer_id) ? ( $user->status == 1 ? 'enable' : 'disable') : null,
					])
				</div>
			</div>

		</div>
		<div class="form-actions util-btn-margin-bottom-5">
			<div class="row">
				<div class="col-md-offset-3 col-md-9">
					@if(! isset($customer_id))
						{!! Form::btnSaveNew() !!}
					@else
						{!! Form::btnSaveOut() !!}
					@endif
				</div>
			</div>
		</div>
	</form>

@endsection

@push('css')
	<link href="{{ asset_url('admin', 'global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
@endpush

@push('js_footer')
	<script type="text/javascript" src="{{ asset_url('admin', 'global/plugins/jquery-form/jquery.form.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset_url('admin', 'global/plugins/bootstrap-toastr/toastr.min.js') }}"></script>
	<script type="text/javascript">
	$(function(){
		$('*[view-password]').change(function(){
			if(this.checked) {
				$('*[name="customer[password]"]').attr('type','text');
				$('*[name="customer[password_confirmation]"]').attr('type','text');
			} else {
				$('*[name="customer[password]"]').attr('type','password');
				$('*[name="customer[password_confirmation]"]').attr('type','password');
			}
		});
	});
	</script>
@endpush
