@extends('Cms::layouts.default',[
	'active_admin_menu' 	=> ['partner', 'partner.all'],
	'breadcrumbs' 			=> [
		'title'	=> ['Cộng tác viên', 'Danh sách', 'Xem'],
		'url'	=> [
			admin_url('partner'),
			admin_url('partner'),
		],
	],
])

@section('page_title', 'Xem chi tiết')

@section('page_sub_title', $partner->full_name)

@section('tool_bar')
	<a href="{{ route('admin.partner.edit', ['id' => $partner->id]) }}" class="btn btn-primary full-width-xs">
		<i class="fa fa-pencil"></i> <span class="hidden-xs">Chỉnh sửa</span>
	</a>
@endsection

@section('content')

@endsection

@push('css')

@endpush

@push('js_footer')

@endpush
