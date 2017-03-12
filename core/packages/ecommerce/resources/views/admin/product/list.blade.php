@extends('Cms::layouts.default',[
	'active_admin_menu' 	=> [ 'ecommerce', ' ecommerce.product', ' ecommerce.product.index'],
	'breadcrumbs' 			=> [
		'title'	=> ['Sản phẩm', 'Danh sách'],
		'url'	=> [route('admin.ecommerce.product.index')],
	],
])

@section('page_title', 'Danh sách sản phẩm')

@section('tool_bar')
	@can('admin.ecommerce.product.create')
		<a href="{{ route('admin.ecommerce.product.create') }}" class="btn btn-primary">
			<i class="fa fa-plus"></i> <span class="hidden-xs">Thêm sản phẩm mới</span>
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
		                            <label class="control-label col-md-3">Thương hiệu</label>
		                            <div class="col-md-9">
	                                	@include('Ecommerce::admin.components.form-select-brand', [
	                                		'brands' => \Packages\Ecommerce\Brand::all(),
	                                		'name' => 'brand_id',
	                                		'selected' => isset($filter['brand_id']) ? $filter['brand_id'] : '0',
	                                	])
		                            </div>
		                        </div>
		                        <div class="form-group">
		                            <label class="control-label col-md-3">Bộ lọc</label>
		                            <div class="col-md-9">
		                                @include('Ecommerce::admin.components.form-select-filter', [
	                                		'filters' => \Packages\Ecommerce\Filter::all(),
	                                		'name' => 'filter_id',
	                                		'selected' => isset($filter['filter_id']) ? $filter['filter_id'] : '0',
	                                	])
		                            </div>
		                        </div>
		                        <div class="form-group">
		                            <label class="control-label col-md-3">Danh mục</label>
		                            <div class="col-md-9">
		                                @include('Ecommerce::admin.components.form-select-category', [
	                                		'categories' => \Packages\Ecommerce\Category::all(),
	                                		'name' => 'category_id',
	                                		'selected' => isset($filter['category_id']) ? $filter['category_id'] : '0',
	                                	])
		                            </div>
		                        </div>
		                        <div class="form-group">
		                            <label class="control-label col-md-3">Tác giả</label>
		                            <div class="col-md-9">
		                            	@include('Cms::components.form-find-user', [
	                                		'name' => 'author_id',
	                                		'selected' => isset($filter['author_id']) ? $filter['author_id'] : '0',
	                                	])
		                            </div>
		                        </div>
		                    </div>
		                    <div class="col-sm-6 md-pl-0">
		                    	<div class="form-group">
		                            <label class="control-label col-md-3">Trạng thái</label>
		                            <div class="col-md-9">
		                                @include('Ecommerce::admin.components.form-select-product-status', [
	                                		'statuses' => \Packages\Ecommerce\Product::statusable()->all(),
	                                		'name' => 'status',
	                                		'selected' => isset($filter['status']) ? $filter['status'] : 'enable',
	                                	])
		                            </div>
		                        </div>
		                        <div class="form-group">
		                            <label class="control-label col-md-3">Quản lí kho</label>
		                            <div class="col-md-9">
		                                @include('Ecommerce::admin.components.form-select-subtract', [
	                                		'subtract' => \Packages\Ecommerce\Product::getSubtractAble(),
	                                		'name' => 'subtract',
	                                		'selected' => isset($filter['subtract']) ? $filter['subtract'] : '0',
	                                	])
		                            </div>
		                        </div>
		                        <div class="form-group">
		                            <label class="control-label col-md-3">Số lượng</label>
		                            <div class="col-md-9">
		                                <div class="row">
		                                	<div class="col-sm-6">
		                                		@include('Cms::components.form-select-math-compare', [
		                                			'name' => 'compare_quantity',
		                                			'target' => '#filter-quantity',
		                                			'base' => 'quantity',
		                                		])
		                                	</div>
		                                	<div class="col-sm-6">
		                                		<input type="text" class="form-control" value="{{ $filter['quantity'] or '' }}" name="quantity" id="filter-quantity" />
		                                	</div>
		                                </div>
		                            </div>
		                        </div>
		                        <div class="form-group">
		                            <label class="control-label col-md-3">Giá</label>
		                            <div class="col-md-9">
		                                <div class="row">
		                                	<div class="col-sm-6">
		                                		@include('Cms::components.form-select-math-compare', [
		                                			'name' => 'compare_price',
		                                			'target' => '#filter-price',
		                                			'base' => 'price',
		                                		])
		                                	</div>
		                                	<div class="col-sm-6">
		                                		<input type="text" class="form-control" value="{{ $filter['price'] or '' }}" name="price" id="filter-price" />
		                                	</div>
		                                </div>
		                            </div>
		                        </div>
		                        <div class="form-group">
		                            <label class="control-label col-md-3">Đang giảm giá</label>
		                            <div class="col-md-9">
		                                <select name="sale" class="form-control">
		                                	<option></option>
		                                	@foreach(\Packages\Ecommerce\Product::getSaleAble() as $sale_item)
												<option {{ isset($filter['sale']) && $filter['sale'] == $sale_item['slug'] ? 'selected' : '' }} value="{{ $sale_item['slug'] }}">{{ $sale_item['name'] }}</option>
		                                	@endforeach
		                                </select>
		                            </div>
		                        </div>
		                    </div>
		                </div>
		            </div>
		            <div class="form-actions util-btn-margin-bottom-5">
		                <div class="row">
		                    <div class="col-md-12 text-right">
		                        <button type="submit" class="btn btn-primary full-width-xs">
		                            <i class="fa fa-filter"></i> Lọc
		                        </button>
		                        <a href="{{ route('admin.ecommerce.product.index') }}" class="btn btn-gray full-width-xs">
		                            <i class="fa fa-times"></i> Hủy
		                        </a>
		                    </div>
		                </div>
		            </div>
		        </form>
		    </div>
		</div>
		<div class="note note-success">
            <p><i class="fa fa-info"></i> Tổng số {{ $products->total() }} kết quả</p>
        </div>
		<div class="row table-above">
		    <div class="col-sm-6">
		    	<div class="form-inline mb-10 apply-action">
			    	@include('Cms::components.form-apply-action', [
			    		'actions' => [
			    			['action' => route('admin.ecommerce.product.multiple-disable'), 'name' => 'Xóa tạm', 'method' => 'PUT'],
			    			['action' => route('admin.ecommerce.product.multiple-enable'), 'name' => 'Khôi phục', 'method' => 'PUT'],
			    			['action' => route('admin.ecommerce.product.multiple-destroy'), 'name' => 'Xóa vĩnh viễn', 'method' => 'DELETE'],
			    		],
			    	])
			    </div>
		    </div>
		    <div class="col-sm-6 text-right table-page">
		    	{!! $products->setPath('product')->appends($filter)->render() !!}
		    </div>
	    </div>
	    <div class="table-responsive main">
			<table class="master-table table table-striped table-hover table-checkable order-column pb-products">
				<thead>
					<tr>
						<th width="50" class="table-checkbox text-center">
							<div class="checker">
								<input type="checkbox" class="icheck check-all">
							</div>
						</th>
						<th class="text-center hidden-xs">
							{!! \Packages\Ecommerce\Product::linkSort('ID', 'id') !!}
						</th>
						<th>
							{!! \Packages\Ecommerce\Product::linkSort('Sản phẩm', 'name') !!}
						</th>
						<th style="min-width: 150px" class="text-center">
							{!! \Packages\Ecommerce\Product::linkSort('Số lượng', 'quantity') !!}
						</th>
						<th style="min-width: 200px" class="text-center">
							{!! \Packages\Ecommerce\Product::linkSort('Giá', 'price') !!}
						</th>
						<th></th>
					</tr>
				</thead>
				<tbody class="pb-products">
					@foreach($products as $product_item)
						<tr class="pb-product-item hover-display-container {{ $product_item->statusHtmlClass() }}">
							<td width="50" class="table-checkbox text-center">
								<div class="checker">
									<input type="checkbox" class="icheck" value="{{ $product_item->id }}">
								</div>
							</td>
		    				<td class="text-center hidden-xs"><strong>{{ $product_item->id }}</strong></td>
		    				<td>
		    					<div class="media">
					                <div class="pull-left">
					                    <img class="img-circle" src="{{ thumbnail_url($product_item->thumbnail, ['width' => '70', 'height' => '70']) }}" alt="" style="max-width: 70px" />
					                </div>

					                <div class="media-body">
					                    <ul class="info unstyle-list">
					                        <li class="name">
					                        	@can('admin.ecommerce.product.edit', $product_item)
					                        	<a target="_blank" href="{{ route('admin.ecommerce.product.edit', ['id' => $product_item->id]) }}">
					                        		<strong>{{ $product_item->name }}</strong>
					                        	</a>
					                        	@endcan
					                        	@cannot('admin.ecommerce.product.edit', $product_item)
					                        		<strong>{{ $product_item->name }}</strong>
					                        	@endcannot
				                        		<span class="hover-display pl-15">
													<a href="#" class="text-sm"><i>Xem nhanh</i></a>
												</span>
					                        </li>
					                        <li>Mã: {{ $product_item->code or trans('cms.empty') }}</li>
					                    </ul>
					                </div>
					            </div>
		    				</td>
		    				<td class="text-center">
		    					<strong>{{ $product_item->quantity }}</strong>
		    					@if($product_item->isSubtract())
			    					<span class="label label-sm label-info">
			    						Tự động trừ
			    						<i class="fa fa-share"></i>
			    					</span>
		    					@endif
		    				</td>
		    				<td>
		    					<strong>
			    					@if($product_item->isSale())
				    					<s>{{ price_format($product_item->price) }}</s> {{ price_format($product_item->promotional_price) }}
			    					@else
				    					{{ price_format($product_item->price) }}
			    					@endif
		    					</strong>
		    				</td>
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
		                            	@if(Route::has('product.show'))
			                                <li><a href="{{ route('product.show', ['slug' => $product_item->slug, 'id' => $product_item->id]) }}"><i class="fa fa-eye"></i> Xem</a></li>
			                                <li class="divider"></li>
		                                @endif
		                                
		                                @can('admin.ecommerce.product.edit', $product_item)
		                                	<li><a href="{{ route('admin.ecommerce.product.edit', ['id' => $product_item->id]) }}"><i class="fa fa-pencil"></i> Sửa</a></li>
			                                @if($product_item->isSubtract())
			                                	<li><a remote-modal data-name="#popup-edit-quantity" data-url="{{ route('admin.ecommerce.product.popup-edit-quantity', ['id' => $product_item->id]) }}"><i class="fa fa-archive"></i> Cập nhật số lượng</a></li>
			                                @endif
			                                <li class="divider"></li>
		                                @endcan
										
		                                @if($product_item->isEnable())
		                                	@can('admin.ecommerce.product.disable', $product_item)
		                                		<li><a data-function="disable" data-method="PUT" href="{{ route('admin.ecommerce.product.disable', ['id' => $product_item->id]) }}"><i class="fa fa-recycle"></i> Ẩn</a></li>
		                                	@endcan
		                                @else
		                                	@can('admin.ecommerce.product.enable', $product_item)
			                                	<li><a data-function="enable" data-method="PUT" href="{{ route('admin.ecommerce.product.enable', ['id' => $product_item->id]) }}"><i class="fa fa-recycle"></i> Công khai</a></li>
			                                @endcan
			                                @can('admin.ecommerce.product.destroy', $product_item)
			                                	<li><a data-function="destroy" data-method="delete" href="{{ route('admin.ecommerce.product.destroy', ['id' => $product_item->id]) }}"><i class="fa fa-times"></i> Xóa</a></li>
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