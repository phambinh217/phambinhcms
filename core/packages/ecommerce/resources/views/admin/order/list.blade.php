@extends('Cms::layouts.default',[
	'active_admin_menu' 	=> ['sales', 'sales.order', 'sales.order.index'],
	'breadcrumbs' 			=> [
		'title'	=> ['Đơn hàng', 'Danh sách'],
		'url'	=> [route('admin.ecommerce.order.index')],
	],
])

@section('page_title', 'Danh sách đơn hàng')

@section('content')
	<div class="portlet light bordered">
	    <div class="portlet-title">
	        <div class="caption">
	            <i class="fa fa-filter"></i> Bộ lọc kết quả
	        </div>
	    </div>
	    <div class="portlet-body form">
	        <form action="#" class="form-horizontal form-bordered form-row-stripped">
	            <div class="form-body">
	                <div class="row">
	                    <div class="col-sm-6 md-pr-0">
	                        <div class="form-group">
	                            <label class="control-label col-md-3">ID</label>
	                            <div class="col-md-9">
	                                <input type="text" class="form-control" name="id" value="{{ $filter['id'] or '' }}" placeholder="ID" />
	                            </div>
	                        </div>
	                        <div class="form-group">
	                            <label class="control-label col-md-3">Khách hàng</label>
	                            <div class="col-md-9">
	                            	@include('Cms::components.form-find-user', [
                                		'name' => 'customer_id',
                                		'selected' => isset($filter['customer_id']) ? $filter['customer_id'] : '0',
                                	])
	                            </div>
	                        </div>
	                        <div class="form-group">
	                            <label class="control-label col-md-3">Trạng thái</label>
	                            <div class="col-md-9">
	                                @include('Ecommerce::admin.components.form-select-order-status', [
						        		'name' => 'status_id',
						        		'selected' => isset($filter['status_id']) ? $filter['status_id'] : '0',
						        		'statuses' => \Packages\Ecommerce\OrderStatus::get(),
						        	])
	                            </div>
	                        </div>
	                    </div>
	                    <div class="col-sm-6 md-pl-0">
	                        <div class="form-group">
	                            <label class="control-label col-md-3">Ngày thêm</label>
	                            <div class="col-md-9">
	                            	<input type="text" class="form-control" />
	                            </div>
	                        </div>
	                        <div class="form-group">
	                            <label class="control-label col-md-3">Ngày cập nhật</label>
	                            <div class="col-md-9">
	                                <input type="text" class="form-control" />
	                            </div>
	                        </div>
	                    </div>
	                </div>
	            </div>
	            <div class="form-actions util-btn-margin-bottom-5">
	                <div class="row">
	                    <div class="col-md-12 text-right">
	                        <button type="submit" class="btn btn-primary">
	                            <i class="fa fa-filter"></i> Lọc
	                        </button>
	                        <a href="{{ route('admin.ecommerce.product.index') }}" class="btn btn-gray">
	                            <i class="fa fa-times"></i> Hủy
	                        </a>
	                    </div>
	                </div>
	            </div>
	        </form>
	    </div>
	</div>
	<div class="table-function-container">
		<div class="note note-success">
	        <p><i class="fa fa-info"></i> Tổng số {{ $orders->total() }} kết quả</p>
	    </div>
		<div class="row table-above">
		    <div class="col-sm-6">
		    	<div class="form-inline mb-10 apply-action">
			    	@include('Cms::components.form-apply-action', [
			    		'actions' => [
			    			['action' => '', 'name' => 'Xóa tạm', 'method' => 'PUT'],
			    			['action' => '', 'name' => 'Khôi phục', 'method' => 'PUT'],
			    			['action' => '', 'name' => 'Xóa vĩnh viễn', 'method' => 'DELETE'],
			    		],
			    	])
			    </div>
		    </div>
		    <div class="col-sm-6 text-right table-page">
		    	{!! $orders->render() !!}
		    </div>
	    </div>
		<table class="master-table table table-striped table-hover table-checkable order-column pb-orders">
			<thead>
				<tr>
					<th width="50" class="table-checkbox text-center">
						<div class="checker">
							<input type="checkbox" class="icheck check-all">
						</div>
					</th>
					<th class="text-center">
						{!! \Packages\Ecommerce\Order::linkSort('ID', 'id') !!}
					</th>
					<th>
						Khách hàng
					</th>
					<th>
						Trạng thái
					</th>
					<th>
						{!! \Packages\Ecommerce\Order::linkSort('Giá trị', 'total') !!}
					</th>
					<th class="text-center">
						{!! \Packages\Ecommerce\Order::linkSort('Ngày thêm', 'created_at') !!}
					</th>
					<th class="text-center">
						{!! \Packages\Ecommerce\Order::linkSort('Ngày cập nhật', 'updated_at') !!}
					</th>
					<th></th>
				</tr>
			</thead>
			<tbody class="pb-orders">
				@foreach($orders as $order_item)
					<tr>
						<td width="50" class="table-checkbox text-center">
							<div class="checker">
								<input type="checkbox" class="icheck" value="{{ $order_item->id }}">
							</div>
						</td>
	    				<td class="text-center"><strong>{{ $order_item->id }}</strong></td>
	    				<td>
                            <img class="img-circle" src="{{ thumbnail_url($order_item->customer->avatar, ['width' => 32, 'height' => 32]) }}" />
                            {{ $order_item->customer->full_name }}
                        </td>
	    				<td>{{ $order_item->status->name }}</td>
	    				<td><strong>{{ price_format($order_item->total) }}</strong></td>
	    				<td class="text-center">{{ text_time_difference($order_item->created_at) }}</td>
	    				<td class="text-center">{{ text_time_difference($order_item->updated_at) }}</td>
	    				<td>
	    					<div class="btn-group pull-right" table-function>
	                            <a href="" class="btn btn-circle btn-xs grey-salsa btn-sm dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"> @lang('cms.action')
	                                <span class="fa fa-angle-down"> </span>
	                            </a>
	                            <ul class="dropdown-menu pull-right">
	                                <li><a href="{{ route('admin.ecommerce.order.show', ['id' => $order_item->id]) }}"><i class="fa fa-eye"></i> Xem</a></li>
	                                <li class="divider"></li>
	                                <li><a href="{{ route('admin.ecommerce.order.edit', ['id' => $order_item->id]) }}"><i class="fa fa-pencil"></i> Sửa</a></li>
	                                <li class="divider"></li>
	                            	<li><a data-function="disable" data-method="PUT" href=""><i class="fa fa-recycle"></i> Ẩn</a></li>
	                                <li><a data-function="enable" data-method="PUT" href=""><i class="fa fa-recycle"></i> Công khai</a></li>
	                                <li><a data-function="destroy" data-method="delete" href=""><i class="fa fa-times"></i> Xóa</a></li>
	                            </ul>
	                        </div>
	    				</td>
					</tr>
				@endforeach
			</tbody>
		</table>
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