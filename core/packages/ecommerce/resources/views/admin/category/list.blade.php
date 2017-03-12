@extends('Cms::layouts.default', [
	'active_admin_menu'	=> [ 'ecommerce', ' ecommerce.category', ' ecommerce.category.index'],
	'breadcrumbs'		=>	[
		'title' => ['Danh mục', 'Danh sách danh mục'],
		'url'	=> [
			route('admin.ecommerce.category.index')
		],
	],	
])

@section('page_title', 'Danh mục sản phẩm')

@section('tool_bar')
	<a href="{{ route('admin.ecommerce.category.create') }}" class="btn btn-primary">
		<i class="fa fa-plus"></i> <span class="hidden-xs">Thêm danh mục mới</span>
	</a>
@endsection

@section('content')	
	<div class="table-function-container">
		<div class="note note-success">
	        <p><i class="fa fa-info"></i> Tổng số {{ $categories->count() }} kết quả</p>
	    </div>
		<div class="row table-above">
		    <div class="col-sm-6">
		    	<div class="form-inline mb-10 apply-action">
			    	@include('Cms::components.form-apply-action', [
			    		'actions' => [
			    			['action' => route('admin.ecommerce.category.multiple-destroy'), 'name' => 'Xóa vĩnh viễn', 'method' => 'DELETE'],
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
							{!! Packages\Ecommerce\Category::linkSort('ID', 'id') !!}
						</th>
						<th class="text-center">
							Ảnh
						</th>
						<th>
							{!! Packages\Ecommerce\Category::linkSort('Danh mục', 'name') !!}
						</th>
						<th class="hidden-xs">
							{!! Packages\Ecommerce\Category::linkSort('Ngày tạo', 'created_at') !!}
						</th>
						<th></th>
					</tr>
				</thead>
				<tbody class="pb-items">
					@include('Ecommerce::admin.components.category.table-items', [
						'categories' => $categories,
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