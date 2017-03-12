@extends('Cms::layouts.default',[
	'active_admin_menu' 	=> ['setting', 'student.setting'],
	'breadcrumbs' 			=> [
		'title'	=> ['Cài đặt', 'Học viên'],
		'url'	=> [route('admin.student.setting')],
	],
])

@section('page_title', 'Cài đặt giảng viên')

@section('content')
	<form class="form-horizontal ajax-form" method="POST" action="{{ route('admin.trainer.setting.update') }}">
		{{ csrf_field() }}
		{{ method_field('PUT') }}
		<div class="form-body">
			<div class="form-group">
				<label class="control-lalel col-sm-3 pull-left">
					Nhóm tài khoản giảng viên
				</label>
				<div class="col-sm-9">
					@include('Cms::components.form-select-role', [
						'roles'		=> Packages\Cms\User\Role::get(),
						'name' 		=> 'trainer_role_id',
						'selected' 	=> $trainer_role_id,
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
