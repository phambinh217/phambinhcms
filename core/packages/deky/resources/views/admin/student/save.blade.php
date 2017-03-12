@extends('Cms::layouts.default',[
	'active_admin_menu' 	=> ['student', isset($student_id) ? 'student.all' : 'student.create'],
	'breadcrumbs' 			=> [
		'title'	=> ['Quản trị viên', isset($student_id) ? trans('cms.edit') : trans('cms.add-new')],
		'url'	=> [
			admin_url('student'),
			admin_url('student'),
		],
	],
])

@section('page_title', isset($student_id) ? 'Chỉnh sửa học viên' : 'Thêm học viên mới')

@if(isset($student_id))
	@section('page_sub_title', $student->full_name)
	@section('tool_bar')
		<a href="{{ route('admin.student.create') }}" class="btn btn-primary full-width-xs">
			<i class="fa fa-plus"></i> <span class="hidden-xs">Thêm học viên mới</span>
		</a>
	@endsection
@endif

@section('content')

	<form action="{{ isset($student_id) ? admin_url('student/' . $student_id)  : admin_url('student') }}" method="post" class="form-horizontal form-bordered form-row-stripped ajax-form">
		@if(isset($student_id))
			<input type="hidden" name="_method" value="PUT" />
		@endif
		{{ csrf_field() }}
		<div class="form-body">
			<p>Học viên có tra cứu thông tin cá nhân, thông tin lớp đang học và đăng ký khóa học mới</p>
			<div class="form-group">
				<label class="control-label col-sm-3 pull-left">
					Họ và tên đệm <span class="required">*</span>
				</label>
				<div class="col-sm-7">
					<input value="{{ $student->last_name or '' }}" name="student[last_name]" type="text" placeholder="" class="form-control">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3 pull-left">
					Tên thật <span class="required">*</span>
				</label>
				<div class="col-sm-7">
					<input value="{{ $student->first_name or '' }}" name="student[first_name]" type="text" placeholder="" class="form-control">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3 pull-left">
					Bí danh <span class="required">*</span>
				</label>
				<div class="col-sm-7">
					<input value="{{ $student->name or '' }}"  name="student[name]" type="text" placeholder="" class="form-control" />
					<span class="help-block"> Một tên ngắn gọn, không bao gồm dấu cách và các ký tự đặc biệt </span>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3 pull-left">
					Số điện thoại <span class="required">*</span>
				</label>
				<div class="col-sm-7">
					<input value="{{ $student->phone or '' }}" name="student[phone]" type="text" placeholder="" class="form-control">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3 pull-left">Ngày sinh</label>
				<div class="col-sm-7">
					<input value="{{ isset($student_id) ? changeFormatDate($student->birth, 'Y-m-d', 'd-m-Y') : '' }}" name="student[birth]" type="text" class="form-control" placeholder="Ví dụ: 21-07-1996">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3 pull-left">
					Địa chỉ email <span class="required">*</span>
				</label>
				<div class="col-sm-7">
					<input value="{{ $student->email or '' }}" name="student[email]" type="text" placeholder="" class="form-control">
					<span class="help-block"> Địa chỉ email sẽ dùng để đăng nhập tài khoản </span>
				</div>
			</div>

			@if(! isset($student_id))
				<div class="form-group">
					<label class="control-label col-sm-3 pull-left">
						Mật khẩu <span class="required">*</span>
					</label>
					<div class="col-sm-7">
						<input name="student[password]" type="password" placeholder="" class="form-control">
						<span class="help-block"> Mật khẩu này sử dụng để đăng nhập tài khoản </span>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-3 pull-left">
						Xác nhận mật khẩu <span class="required">*</span>
					</label>
					<div class="col-sm-7">
						<input name="student[password_confirmation]" type="password" placeholder="" class="form-control">
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

			<div class="form-group last">
				<label class="control-label col-sm-3 pull-left">
					Trạng thái <span class="required">*</span>
				</label>
				<div class="col-sm-7">
					<select name="student[status]" class="form-control width-auto">
						<option {{ isset($student_id) && $student->status == '1' ? 'selected' : '' }} value="1">Bình thường</option>
						<option {{ isset($student_id) && $student->status == '0' ? 'selected' : '' }} value="0">Cấm</option>
					</select>
				</div>
			</div>
		</div>
		<div class="form-actions util-btn-margin-bottom-5">
			<div class="row">
				<div class="col-md-offset-3 col-md-9">
					@if(! isset($student_id))
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
				$('*[name="student[password]"]').attr('type','text');
				$('*[name="student[password_confirmation]"]').attr('type','text');
			} else {
				$('*[name="student[password]"]').attr('type','password');
				$('*[name="student[password_confirmation]"]').attr('type','password');
			}
		});
	});
	</script>
@endpush
