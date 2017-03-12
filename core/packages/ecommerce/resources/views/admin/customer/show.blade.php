@extends('Cms::layouts.default',[
	'active_admin_menu' 	=> ['customer', 'customer.all'],
	'breadcrumbs' 			=> [
		'title'	=> ['Khách hàng', 'Danh sách', 'Xem'],
		'url'	=> [
			route('admin.ecommerce.customer.index'),
			route('admin.ecommerce.customer.index'),
		],
	],
])

@section('page_title', 'Xem chi tiết')

@section('page_sub_title', $customer->full_name)

@section('tool_bar')
	<a href="{{ route('admin.ecommerce.customer.edit', ['id' => $customer->id]) }}" class="btn btn-primary">
		<i class="fa fa-pencil"></i> <span class="hidden-xs">Chỉnh sửa</span>
	</a>
@endsection

@section('content')

@endsection

@push('css')

@endpush

@push('js_footer')

@endpush
