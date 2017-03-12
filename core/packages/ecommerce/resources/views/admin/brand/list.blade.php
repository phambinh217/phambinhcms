@extends('Cms::layouts.default', [
	'active_admin_menu'	=> [ 'ecommerce', ' ecommerce.brand', ' ecommerce.brand.index'],
	'breadcrumbs'		=>	[
		'title' => ['Thương hiệu', 'Danh sách thương hiệu'],
		'url'	=> [
			route('admin.ecommerce.brand.index')
		],
	],	
])

@section('page_title', 'Thương hiệu sản phẩm')

@section('tool_bar')
	@can('admin.ecommerce.brand.create')
		<a href="{{ route('admin.ecommerce.brand.create') }}" class="btn btn-primary">
			<i class="fa fa-plus"></i> <span class="hidden-xs">Thêm thương hiệu mới</span>
		</a>
	@endcan
@endsection

@section('content')	
	<div class="table-function-container">
		<div class="note note-success">
	        <p><i class="fa fa-info"></i> Tổng số {{ $brands->count() }} kết quả</p>
	    </div>
		<div class="row table-above">
		    <div class="col-sm-6">
		    	<div class="form-inline mb-10 apply-action">
			    	@include('Cms::components.form-apply-action', [
			    		'actions' => [
			    			['action' => route('admin.ecommerce.brand.multiple-destroy'), 'name' => 'Xóa vĩnh viễn', 'method' => 'DELETE'],
			    		],
			    	])
			    </div>
		    </div>
		    <div class="col-sm-6 text-right table-page"></div>
	    </div>
	    <div class="table-responsive main">
			<table class="master-table table table-striped table-hover table-checkable order-column pb-items">
				<thead>
					<tr>
						<th width="50" class="table-checkbox text-center">
							<div class="checker">
								<input type="checkbox" class="icheck check-all">
							</div>
						</th>
						<th class="text-center hidden-xs">
							{!! Packages\Ecommerce\Brand::linkSort('ID', 'id') !!}
						</th>
						<th class="text-center">
							Logo
						</th>
						<th class="text-center">
							{!! Packages\Ecommerce\Brand::linkSort('Thương hiệu', 'name') !!}
						</th>
						<th class="text-center hidden-xs">
							{!! Packages\Ecommerce\Brand::linkSort('Ngày tạo', 'created_at') !!}
						</th>
						<th></th>
					</tr>
				</thead>
				<tbody class="pb-items">
					@include('Ecommerce::admin.components.brand.table-items', [
						'brands' => $brands,
					])
				</tbody>
			</table>
		</div>
	</div>
@endsection

@push('css')
	<link href="{{ asset_url('admin', 'global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
	<link href="{{ asset_url('admin', 'global/plugins/icheck/skins/all.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push('js_footer')
	<script type="text/javascript" src="{{ asset_url('admin', 'global/plugins/bootstrap-toastr/toastr.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset_url('admin', 'global/plugins/icheck/icheck.min.js')}} "></script>
@endpush