@extends('Cms::layouts.default',[
	'active_admin_menu' 	=> ['partner', 'partner.create'],
	'breadcrumbs' 			=> [
		'title'	=> ['Cộng tác viên', trans('cms.add-new')],
		'url'	=> [
			admin_url('partner'),
		],
	],
])

@section('page_title', 'Thêm cộng tác viên mới')


@if(isset($partner_id))
	@section('page_sub_title', $partner->full_name)
	@section('tool_bar')
		<a href="{{ route('admin.partner.create') }}" class="btn btn-primary full-width-xs">
			<i class="fa fa-plus"></i> <span class="hidden-xs">Thêm giảng viên mới</span>
		</a>
	@endsection
@endif

@section('content')

	<form action="{{ isset($partner_id) ? admin_url('partner/' . $partner_id)  : admin_url('partner') }}" method="post" class="form-horizontal form-bordered form-row-stripped ajax-form">
		@if(isset($partner_id))
			<input type="hidden" name="_method" value="PUT" />
		@endif
		{{ csrf_field() }}
		<div class="form-body">
			<p>Cộng tác viên có quyền giới thiệu học viên và xem thông tin học viên của mình</p>
			<div class="form-group">
				<label class="control-label col-sm-3 pull-left">
					Họ và tên đệm <span class="required">*</span>
				</label>
				<div class="col-sm-7">
					<input value="{{ $partner->last_name or '' }}" name="partner[last_name]" type="text" placeholder="" class="form-control">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3 pull-left">
					Tên thật <span class="required">*</span>
				</label>
				<div class="col-sm-7">
					<input value="{{ $partner->first_name or '' }}" name="partner[first_name]" type="text" placeholder="" class="form-control">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3 pull-left">
					Bí danh <span class="required">*</span>
				</label>
				<div class="col-sm-7">
					<input value="{{ $partner->name or '' }}"  name="partner[name]" type="text" placeholder="" class="form-control" />
					<span class="help-block"> Một tên ngắn gọn, không bao gồm dấu cách và các ký tự đặc biệt </span>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3 pull-left">
					Số điện thoại <span class="required">*</span>
				</label>
				<div class="col-sm-7">
					<input value="{{ $partner->phone or '' }}" name="partner[phone]" type="text" placeholder="" class="form-control">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3 pull-left">Ngày sinh</label>
				<div class="col-sm-7">
					<input value="{{ isset($partner_id) ? changeFormatDate($partner->birth, 'Y-m-d', 'd-m-Y') : '' }}" name="partner[birth]" type="text" class="form-control" placeholder="Ví dụ: 21-07-1996">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3 pull-left">
					Địa chỉ email <span class="required">*</span>
				</label>
				<div class="col-sm-7">
					<input value="{{ $partner->email or '' }}" name="partner[email]" type="text" placeholder="" class="form-control">
					<span class="help-block"> Địa chỉ email sẽ dùng để đăng nhập tài khoản </span>
				</div>
			</div>

			@if(! isset($partner_id))
				<div class="form-group">
					<label class="control-label col-sm-3 pull-left">
						Mật khẩu <span class="required">*</span>
					</label>
					<div class="col-sm-7">
						<input name="partner[password]" type="password" placeholder="" class="form-control">
						<span class="help-block"> Mật khẩu này sử dụng để đăng nhập tài khoản </span>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-3 pull-left">
						Xác nhận mật khẩu <span class="required">*</span>
					</label>
					<div class="col-sm-7">
						<input name="partner[password_confirmation]" type="password" placeholder="" class="form-control">
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
			<div class="form-group">
				<label class="control-label col-sm-3 pull-left">
					Địa chỉ
				</label>
				<div class="col-sm-7">
					<textarea name="partner[address]" class="form-control">{{ $partner->address }}</textarea>
				</div>
			</div>
			<div class="form-group last">
				<label class="control-label col-sm-3 pull-left">
					Trạng thái <span class="required">*</span>
				</label>
				<div class="col-sm-7">
					<select name="partner[status]" class="form-control width-auto">
						<option {{ isset($partner_id) && $partner->status == '1' ? 'selected' : '' }} value="1">Bình thường</option>
						<option {{ isset($partner_id) && $partner->status == '0' ? 'selected' : '' }} value="0">Cấm</option>
					</select>
				</div>
			</div>
		</div>
		<div class="form-actions util-btn-margin-bottom-5">
			<div class="row">
				<div class="col-md-offset-3 col-md-9">
					@if(! isset($partner_id))
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
		pb.ajaxForm();
		$('*[view-password]').change(function(){
			if(this.checked) {
				$('*[name="partner[password]"]').attr('type','text');
				$('*[name="partner[password_confirmation]"]').attr('type','text');
			} else {
				$('*[name="partner[password]"]').attr('type','password');
				$('*[name="partner[password_confirmation]"]').attr('type','password');
			}
		});
	});
	</script>
@endpush
