@extends('Cms::layouts.default',[
	'active_admin_menu' 	=> ['administrator', 'administrator.all'],
	'breadcrumbs' 			=> [
		'title'	=> ['Quản trị viên', 'Danh sách', 'Xem'],
		'url'	=> [
			admin_url('administrator'),
			admin_url('administrator'),
		],
	],
])

@section('page_title', 'Xem chi tiết')

@section('page_sub_title', $student->full_name)

@section('tool_bar')
	<a href="{{ route('admin.student.edit',['id' => $student->id]) }}" class="btn btn-primary full-width-xs">
		<i class="fa fa-pencil"></i> <span class="hidden-xs">Chỉnh sửa</span>
	</a>
@endsection

@section('content')

@endsection

@push('css')

@endpush

@push('js_footer')

@endpush
