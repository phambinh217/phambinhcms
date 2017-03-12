@extends('Cms::layouts.default',[
	'active_admin_menu' 	=> ['work', 'work.my-student'],
	'breadcrumbs' 			=> [
		'title'	=> ['Công việc', 'Học viên của tôi', isset($student_id) ? 'Thêm học' : trans('cms.edit') ],
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
		<a href="{{ admin_url('work/my-student/registry/create') }}" class="btn btn-primary full-width-xs">
			<i class="fa fa-plus"></i> <span class="hidden-xs">Thêm học viên mới</span>
		</a>
	@endsection
@endif

@section('content')

	<form action="{{ isset($class_id) ? admin_url('work/my-student/registry/' . $class_id )  : admin_url('work/my-student/registry') }}" method="post" class="form-horizontal form-bordered form-row-stripped ajax-form">
		@if(isset($class_id))
			<input type="hidden" name="_method" value="PUT" />
		@endif
		{{ csrf_field() }}
		<div class="form-body">
			<p>Thêm học viên của bạn. Học viên này sẽ được đánh dâu là do bạn giới thiệu</p>
            <div class="form-group form-group-lg">
				<label class="control-label col-sm-3 pull-left">
					Khóa học <span class="required">*</span>
				</label>
				<div class="col-sm-7">
					@include('Deky::admin.components.form-find-course', [
                		'name' => 'class[course_id]',
                		'selected' => isset($class_id) ? $course->id : '',
                	])
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
				<label class="control-label col-sm-3 pull-left">
					Địa chỉ email <span class="required">*</span>
				</label>
				<div class="col-sm-7">
					<input value="{{ $student->email or '' }}" name="student[email]" type="text" placeholder="" class="form-control">
					<span class="help-block"> Địa chỉ email sẽ dùng để đăng nhập tài khoản </span>
				</div>
			</div>
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
				<label class="control-label col-sm-3 pull-left">Ngày sinh</label>
				<div class="col-sm-7">
					<input value="{{ isset($student_id) ? changeFormatDate($student->birth, 'Y-m-d', 'd-m-Y') : '' }}" name="student[birth]" type="text" class="form-control" placeholder="Ví dụ: 21-07-1996">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3 pull-left">
					Ghi chú
				</label>
				<div class="col-sm-7">
					<textarea class="form-control" name="class[comment]">{{ $class->comment or '' }}</textarea>
				</div>
			</div>
		</div>
		<div class="form-actions util-btn-margin-bottom-5">
			<div class="row">
				<div class="col-md-offset-3 col-md-9">
					@if(! isset($class_id))
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
	</script>
@endpush

@include('Class1::admin.component.find-and-fill-student')
