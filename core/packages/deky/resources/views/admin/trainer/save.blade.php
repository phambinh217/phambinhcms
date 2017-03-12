@extends('Cms::layouts.default',[
	'active_admin_menu' 	=> ['trainer', isset($trainer_id) ? 'trainer.all' : 'trainer.create'],
	'breadcrumbs' 			=> [
		'title'	=> ['Giảng viên', isset($trainer_id) ? trans('cms.edit') : trans('cms.add-new')],
		'url'	=> [
			admin_url('trainer'),
		],
	],
])

@section('page_title', isset($trainer_id) ? 'Chỉnh sửa giảng viên' : 'Thêm giảng viên mới')


@if(isset($trainer_id))
	@section('page_sub_title', $trainer->full_name)
	@section('tool_bar')
		<a href="{{ route('admin.trainer.create') }}" class="btn btn-primary full-width-xs">
			<i class="fa fa-plus"></i> <span class="hidden-xs">Thêm giảng viên mới</span>
		</a>
	@endsection
@endif

@section('content')

	<form action="{{ isset($trainer_id) ? admin_url('trainer/' . $trainer_id)  : admin_url('trainer') }}" method="post" class="form-horizontal form-bordered form-row-stripped ajax-form">
		@if(isset($trainer_id))
			<input type="hidden" name="_method" value="PUT" />
		@endif
		{{ csrf_field() }}
		<div class="form-body">
			<p>Giảng viên có quyền giới thiệu học viên, quản lí lớp học của mình</p>
			<div class="form-group">
				<label class="control-label col-sm-3 pull-left">
					Họ và tên đệm <span class="required">*</span>
				</label>
				<div class="col-sm-7">
					<input value="{{ $trainer->last_name or '' }}" name="trainer[last_name]" type="text" placeholder="" class="form-control">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3 pull-left">
					Tên thật <span class="required">*</span>
				</label>
				<div class="col-sm-7">
					<input value="{{ $trainer->first_name or '' }}" name="trainer[first_name]" type="text" placeholder="" class="form-control">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3 pull-left">
					Bí danh <span class="required">*</span>
				</label>
				<div class="col-sm-7">
					<input value="{{ $trainer->name or '' }}"  name="trainer[name]" type="text" placeholder="" class="form-control" />
					<span class="help-block"> Một tên ngắn gọn, không bao gồm dấu cách và các ký tự đặc biệt </span>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3 pull-left">
					Số điện thoại <span class="required">*</span>
				</label>
				<div class="col-sm-7">
					<input value="{{ $trainer->phone or '' }}" name="trainer[phone]" type="text" placeholder="" class="form-control">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3 pull-left">Ngày sinh</label>
				<div class="col-sm-7">
					<input value="{{ isset($trainer_id) ? changeFormatDate($trainer->birth, 'Y-m-d', 'd-m-Y') : '' }}" name="trainer[birth]" type="text" class="form-control" placeholder="Ví dụ: 21-07-1996">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3 pull-left">
					Địa chỉ email <span class="required">*</span>
				</label>
				<div class="col-sm-7">
					<input value="{{ $trainer->email or '' }}" name="trainer[email]" type="text" placeholder="" class="form-control">
					<span class="help-block"> Địa chỉ email sẽ dùng để đăng nhập tài khoản </span>
				</div>
			</div>

			@if(! isset($trainer_id))
				<div class="form-group">
					<label class="control-label col-sm-3 pull-left">
						Mật khẩu <span class="required">*</span>
					</label>
					<div class="col-sm-7">
						<input name="trainer[password]" type="password" placeholder="" class="form-control">
						<span class="help-block"> Mật khẩu này sử dụng để đăng nhập tài khoản </span>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-3 pull-left">
						Xác nhận mật khẩu <span class="required">*</span>
					</label>
					<div class="col-sm-7">
						<input name="trainer[password_confirmation]" type="password" placeholder="" class="form-control">
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
					<textarea name="trainer[address]" class="form-control">{{ $trainer->address }}</textarea>
				</div>
			</div>
			<div class="form-group last">
				<label class="control-label col-sm-3 pull-left">
					Trạng thái <span class="required">*</span>
				</label>
				<div class="col-sm-7">
					<select name="trainer[status]" class="form-control width-auto">
						<option {{ isset($trainer_id) && $trainer->status == '1' ? 'selected' : '' }} value="1">Bình thường</option>
						<option {{ isset($trainer_id) && $trainer->status == '0' ? 'selected' : '' }} value="0">Cấm</option>
					</select>
				</div>
			</div>
		</div>
		<div class="form-actions util-btn-margin-bottom-5">
			<div class="row">
				<div class="col-md-offset-3 col-md-9">
					@if(! isset($trainer_id))
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
				$('*[name="trainer[password]"]').attr('type','text');
				$('*[name="trainer[password_confirmation]"]').attr('type','text');
			} else {
				$('*[name="trainer[password]"]').attr('type','password');
				$('*[name="trainer[password_confirmation]"]').attr('type','password');
			}
		});
	});
	</script>
@endpush
