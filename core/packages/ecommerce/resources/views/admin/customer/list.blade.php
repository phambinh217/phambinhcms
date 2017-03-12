@extends('Cms::layouts.default',[
	'active_admin_menu' 	=> ['customer', 'customer.all'],
	'breadcrumbs' 			=> [
		'title'	=> ['Khách hàng', 'Danh sách'],
		'url'	=> [
			route('admin.ecommerce.customer.index'),
			route('admin.ecommerce.customer.index')
		],
	],
])

@section('page_title', 'Danh sách khách hàng')

@section('tool_bar')
	@can('admin.ecommerce.customer.create')
		<a href="{{ route('admin.ecommerce.customer.create') }}" class="btn btn-primary">
			<i class="fa fa-plus"></i> <span class="hidden-xs">Thêm khách hàng mới</span>
		</a>
	@endcan
@endsection

@section('content')
	<div class="table-function-container">
		<div class="portlet light bordered">
		    <div class="portlet-title">
		        <div class="caption">
		            <i class="fa fa-filter"></i> Bộ lọc kết quả
		        </div>
		        <div class="tools">
		        	<a href="javascript:;" class="collapse" data-original-title="" title=""></a>
		        </div>
		    </div>
		    <div class="portlet-body form">
		        <form action="#" class="form-horizontal form-bordered form-row-stripped">
		            <div class="form-body">
		                <div class="row">
		                    <div class="col-sm-6 md-pr-0">
		                        <div class="form-group">
		                            <label class="control-label col-md-3">Tìm kiếm</label>
		                            <div class="col-md-9">
		                                <input type="text" class="form-control" name="_keyword" value="{{ $filter['_keyword'] or '' }}" />
		                            </div>
		                        </div>
		                        <div class="form-group">
		                            <label class="control-label col-md-3">Quyền quản trị</label>
		                            <div class="col-md-9">
		                                @include('Cms::components.form-select-role', [
		                                	'roles'		=> Packages\Cms\Role::get(),
		                                	'name' 		=> 'role_id',
		                                	'selected' 	=> isset($filter['role_id']) ? $filter['role_id'] : NULL,
		                                ])
		                            </div>
		                        </div>
		                    </div>
		                    <div class="col-sm-6 md-pl-0">
		                        <div class="form-group">
		                            <label class="control-label col-md-3">Trạng thái</label>
		                            <div class="col-md-9">
		                                @include('Cms::components.form-select-status', [
		                                	'status'	=> Packages\Cms\User::statusable()->all(),
		                                	'name' 		=> 'status',
		                                	'selected' 	=> isset($filter['status']) ? $filter['status'] : NULL,
		                                ])
		                            </div>
		                        </div>
		                    </div>
		                </div>
		            </div>
		            <div class="form-actions util-btn-margin-bottom-5">
		                <div class="row util-btn-margin-bottom-5">
		                    <div class="col-md-12 text-right">
		                        <button type="submit" class="btn btn-primary full-width-xs">
		                            <i class="fa fa-filter"></i> Lọc</button>
		                        <a href="{{ route('admin.ecommerce.customer.index') }}" class="btn btn-gray full-width-xs">
		                            <i class="fa fa-times"></i> Hủy
		                        </a>
		                    </div>
		                </div>
		            </div>
		        </form>
		    </div>
		</div>
		<div class="note note-success">
            <p><i class="fa fa-info"></i> Tổng số {{ $customers->total() }} kết quả</p>
        </div>
		<div class="row table-above">
		    <div class="col-sm-6">
		    	<div class="form-inline mb-10">
			    	@include('Cms::components.form-apply-action', [
			    		'actions' => [
			    			['action' => '', 'name' => ''],
			    			['action' => '', 'name' => ''],
			    			['action' => '', 'name' => ''],
			    		],
			    	])
			    </div>
		    </div>
		    <div class="col-sm-6 text-right">
		    	{!! $customers->setPath('customer')->appends($filter)->render() !!}
		    </div>
	    </div>
	    <div class="table-responsive main">
			<table class="master-table table table-striped table-hover table-checkable order-column pb-customers">
				<thead>
					<tr>
						<th width="50" class="table-checkbox text-center">
							<div class="checker">
								<input type="checkbox" class="icheck check-all">
							</div>
						</th>
						<th class="text-center hidden-xs">
							{!! Packages\Cms\User::linkSort('ID', 'id') !!}
						</th>
						<th>
							{!! Packages\Cms\User::linkSort('Họ và tên', 'first_name') !!}
						</th>
						<th class="hidden-xs">
							{!! Packages\Cms\User::linkSort('Ngày đăng ký', 'created_at') !!}
						</th>
						<th></th>
					</tr>
				</thead>
				<tbody class="pb-customers">
					@foreach($customers as $customer_item)
						<tr class="pb-customer-item hover-display-container">
							<td width="50" class="table-checkbox text-center">
								<div class="checker">
									<input type="checkbox" class="icheck" value="{{ $customer_item->id }}">
								</div>
							</td>
							<td class="text-center hidden-xs"><strong>{{ $customer_item->id }}</strong></td>
		    				<td>
		    					<div class="media">
					                <div class="pull-left">
					                    <img class="img-circle" src="{{ thumbnail_url($customer_item->avatar, ['width' => '70', 'height' => '70']) }}" alt="" style="max-width: 70px" />
					                </div>

					                <div class="media-body">
					                    <ul class="info unstyle-list">
					                        <li class="name">
					                        	@can('admin.ecommerce.customer.edit', $customer_item)
						                        	<a href="{{ route('admin.ecommerce.customer.show', ['id' => $customer_item->id]) }}">
						                        		<strong>{{ $customer_item->full_name }}</strong>
						                        	</a>
					                        	@endcan
					                        	@cannot('admin.ecommerce.customer.edit', $customer_item)
					                        		<strong>{{ $customer_item->full_name }}</strong>
					                        	@endcannot
					                        	<span class="label label-sm label-info">
						                        	{{ $customer_item->role_name }}
			                                        <i class="fa fa-share"></i>
			                                    </span>
				                        		<span class="hover-display pl-15">
				                        			@can('admin.ecommerce.customer.show', $customer_item)
														<a href="#" remote-modal data-name="#popup-show-customer" data-url="{{ route('admin.ecommerce.customer.popup-show', ['id' => $customer_item->id]) }}" class="text-sm"><i>Xem nhanh |</i></a>
													@endcan
													<a href="" class="text-sm"><i>Gửi tin nhắn</i></a>
												</span>
					                        </li>
					                        <li class="hidden-xs">NS: {{ $customer_item->birth or trans('cms.empty') }}</li>
					                        <li class="hidden-xs">SĐT: {{ $customer_item->phone or trans('cms.empty') }}</li>
					                        <li class="hidden-xs">Email: {{ $customer_item->email or trans('cms.empty') }}</li>
					                    </ul>
					                </div>
					            </div>
		    				</td>
		    				<td class="hidden-xs" style="min-width: 200px">{{ text_time_difference($customer_item->created_at) }}</td>
		    				<td>
		    					<div class="btn-group pull-right" table-function>
		                            <a href="" class="btn btn-circle btn-xs grey-salsa btn-sm dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"> 
		                            	<span class="hidden-xs">
		                            		@lang('cms.action')
		                            		<span class="fa fa-angle-down"> </span>
		                            	</span>
		                            	<span class="visible-xs">
		                            		<span class="fa fa-cog"> </span>
		                            	</span>
		                            </a>
		                            <ul class="dropdown-menu pull-right">
		                            	@can('admin.ecommerce.customer.show', $customer_item)
			                                <li><a href="{{ route('admin.ecommerce.customer.show', ['id' => $customer_item->id]) }}"><i class="fa fa-eye"></i> Xem</a></li>
			                                <li role="presentation" class="divider"> </li>
		                                @endcan
		                                @can('admin.ecommerce.customer.edit', $customer_item)
		                                	<li><a href="{{ route('admin.ecommerce.customer.edit', ['id' => $customer_item->id]) }}"><i class="fa fa-pencil"></i> Sửa</a></li>
		                                @endcan
		                                @can('admin.ecommerce.customer.disable', $customer_item)
			                            	@if($customer_item->isEnable() && ! $customer_item->isSelf($customer_item->id))
			                            		<li><a data-function="disable" data-method="put" href="{{ route('admin.ecommerce.customer.disable', ['id' => $customer_item->id]) }}"><i class="fa fa-recycle"></i> Xóa tạm</a></li>
			                            	@endif
		                            	@endcan

		                            	@if($customer_item->isDisable())
		                            		@can('admin.ecommerce.customer.enable', $customer_item)
			                            		<li><a data-function="enable" data-method="put" href="{{ route('admin.ecommerce.customer.enable', ['id' => $customer_item->id]) }}"><i class="fa fa-recycle"></i> Khôi phục</a></li>
			                            		<li role="presentation" class="divider"></li>
		                            		@endcan
		                            		@can('admin.ecommerce.customer.destroy', $customer_item)
		                            			<li><a data-function="destroy" data-method="delete" href="{{ route('admin.ecommerce.customer.destroy', ['id' => $customer_item->id]) }}"><i class="fa fa-times"></i> Xóa</a></li>
		                            		@endcan
		                            	@endif
		                            </ul>
		                        </div>
		    				</td>
						</tr>
					@endforeach
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