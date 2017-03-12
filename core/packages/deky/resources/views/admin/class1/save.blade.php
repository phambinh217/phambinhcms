@extends('Cms::layouts.default',[
	'active_admin_menu' 	=> ['course', 'course.all'],
	'breadcrumbs' 			=> [
		'title'	=> ['Khóa học', 'Danh sách khóa học', 'Quản lí học viên', isset($class_id) ? 'Chỉnh sửa học viên' : 'Thêm học viên'],
		'url'	=> [
			route('admin.course.index'),
			route('admin.course.index'),
			route('admin.course.index'),
		],
	],
])

@section('page_title', isset($class_id) ? 'Chỉnh sửa học viên' : 'Thêm học viên')
@section('page_sub_title', $course->title)

@if(isset($class_id))
    @section('tool_bar')
        <a href="{{ route('admin.course.class.create', ['id' => $course->id]) }}" class="btn btn-primary full-width-xs">
            <i class="fa fa-plus"></i> <span class="hidden-xs">Thêm học viên mới</span>
        </a>
    @endsection
@endif

@section('content')

	<form action="{{ isset($class_id) ? route('admin.class.update', ['id' => $class_id]) : route('admin.course.class.show', ['id' => $course->id]) }}" method="post" class="form-horizontal form-bordered form-row-stripped ajax-form">
		@if(isset($class_id))
			<input type="hidden" name="_method" value="PUT" />
		@endif
		{{ csrf_field() }}
		<div class="form-body">
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
					<input value="{{ isset($student->id) ? changeFormatDate($student->birth, 'Y-m-d', 'd-m-Y') : '' }}" name="student[birth]" type="text" class="form-control" placeholder="Ví dụ: 21-07-1996">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3 pull-left">
					Địa chỉ
				</label>
				<div class="col-sm-7">
					<textarea class="form-control" name="student[address]">{{ $student->address or '' }}</textarea>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3 pull-left">
					Người giới thiệu
				</label>
				<div class="col-sm-7">
					@include('Cms::components.form-find-user', [
	            		'name' => 'class[user_intro_id]',
	            		'selected' => isset($class_id) && $class->user_intro_id != 0 ? $class->user_intro_id : '',
	            	])
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3 pull-left">
					Số tiền phải đóng
				</label>
				<div class="col-sm-7">
					<input value="{{ $class->value_require or $course->price }}" name="class[value_require]" type="text" placeholder="" class="form-control" />
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
			<div class="form-group last">
				<label class="control-label col-sm-3 pull-left">
					Nhóm <span class="required">*</span>
				</label>
				<div class="col-sm-7">
					@include('Student::admin.components.form-select-group', [
						'name' => 'class[student_group_id]',
						'groups' => Packages\Deky\StudentGroup::get(),
						'class' => 'width-auto',
						'selected' => isset($class_id) ? $class->student_group_id : '',
					])
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
@endpush

@if(! isset($class_id))
	@include('Class1::admin.component.find-and-fill-student')
@endif