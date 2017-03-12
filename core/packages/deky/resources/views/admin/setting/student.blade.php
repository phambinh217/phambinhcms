@extends('Cms::layouts.default',[
	'active_admin_menu' 	=> ['setting', 'student.setting'],
	'breadcrumbs' 			=> [
		'title'	=> ['Cài đặt', 'Học viên'],
		'url'	=> [route('admin.student.setting')],
	],
])

@section('page_title', 'Cài đặt học viên')

@section('content')
	<form class="form-horizontal ajax-form" method="POST" action="{{ route('admin.student.setting.update') }}">
		{{ csrf_field() }}
		{{ method_field('PUT') }}
		<div class="form-body">
			<div class="form-group">
				<label class="control-lalel col-sm-3 pull-left">
					Nhóm tài khoản khách hàng
				</label>
				<div class="col-sm-9">
					@include('Cms::components.form-select-role', [
						'roles'		=> Packages\Cms\User\Role::get(),
						'name' 		=> 'student_role_id',
						'selected' 	=> $student_role_id,
						'class' => 'width-auto',
					])
				</div>
			</div>
			<div class="form-group">
				<label class="control-lalel col-sm-3 pull-left">
					Nhóm học viên mặc định
				</label>
				<div class="col-sm-9">
					@include('Student::admin.components.form-select-group', [
						'groups'	=> Packages\Deky\StudentGroup::get(),
						'name' 		=> 'default_group_student_id',
						'selected' 	=> $default_group_student_id,
						'class' => 'width-auto',
					])
				</div>
			</div>
		</div>
		<div class="form-actions util-btn-margin-bottom-5">
			<button class="btn btn-primary full-width-xs">
				<i class="fa fa-check"></i> Lưu cài đặt
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
