@extends('Cms::layouts.default',[
	'active_admin_menu' 	=> ['sales.order', 'sales.order.index'],
	'breadcrumbs' 			=> [
		'title'	=> ['Đơn hàng', trans('cms.edit')],
		'url'	=> [route('admin.ecommerce.order.index')],
	],
])

@section('page_title', 'Chỉnh sửa đơn hàng')

@section('content')
	<form action="" method="get" accept-charset="utf-8">
		<div class="portlet light bordered form-fit">
			<div class="portlet-body form">
				<div class="tabbable-line">
					<ul class="nav nav-tabs">
						<li class="active">
							<a href="#customer-info" data-toggle="tab" aria-expanded="true"> Thông tin khách hàng </a>
						</li>
						<li class="">
							<a href="#cart" data-toggle="tab" aria-expanded="false"> Giỏ hàng </a>
						</li>
					</ul>
					<div class="form-horizontal form-bordered form-row-stripped">
						<div class="tab-content">
							<div class="tab-pane active" id="customer-info">
								<div class="form-group">
									<label class="control-label col-sm-2">Tài khoản đặt hàng</label>
									<div class="col-sm-10">
										@include('Cms::components.form-find-user', [
											'name' => 'customer_id',
											'selected' => isset($order_id) ? $order->customer_id : '0',
										])
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-2">Họ và tên người nhận</label>
									<div class="col-sm-10">
										<div class="row">
											<div class="col-sm-6">
												<input type="text" name="" value="{{ $order->last_name }}" class="form-control" placeholder="Họ và tên đệm" />
											</div>
											<div class="col-sm-6">
												<input type="text" name="" value="{{ $order->first_name }}" placeholder="Tên" class="form-control" value="" />
											</div>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-2">Số điện thoại người nhận</label>
									<div class="col-sm-10">
										<input type="text" name="" value="{{ $order->phone }}" class="form-control" placeholder="" />
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-2">Email người nhận</label>
									<div class="col-sm-10">
										<input type="text" name="" value="{{ $order->email }}" class="form-control" placeholder="" />
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-2">Địa chỉ người nhận</label>
									<div class="col-sm-10">
										<textarea class="form-control">{{ $order->address }}</textarea>
									</div>
								</div>
							</div>
							<div class="tab-pane" id="cart">
								<div style="padding: 0 15px">
									<div class="table-responsive">
										<table class="table table-bordered">
											<thead>
												<tr>
													<th>Sản phẩm</th>
													<th>Mã sản phẩm</th>
													<th>Số lượng</th>
													<th>Đơn giá</th>
													<th>Tổng tiền</th>
													<th></th>
												</tr>
											</thead>
											<tbody>
												<tr v-for="product in order_products">
													<td>
														@{{ product.product_info.name }}
														<div v-if="product.options.length != 0">
															<p v-for="option_item in product.options" style="margin: 0">
																<small>@{{ option_item.name }}: @{{ option_item.value }}</small>
															</p>
														</div>
													</td>
													<td>@{{ product.product_info.code }}</td>
													<td>
														<input type="text" :value="product.quantity" class="form-control" />
													</td>
													<td>@{{ product.price }}</td>
													<td>@{{ product.price * product.quantity }}</td>
													<td>
														<button type="button" title="Remove" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button>
													</td>
												</tr>
												<tr>
													<td colspan="5"></td>
													<td><button class="btn btn-primary product-browser-open"><i class="fa fa-plus"></i></button></td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="form-actions util-btn-margin-bottom-5">
					<div class="row">
						<div class="col-md-offset-3 col-md-9">
							@if(!isset($order_id))
								{!! Form::btnSaveNew() !!}
							@else
								{!! Form::btnSaveOut() !!}
							@endif
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
@endsection

@push('css')

@endpush

@push('js_footer')
	<script type="text/javascript" src="{{ url('assets/shop/js/product-browser.js') }}"></script>
	<script type="text/javascript" src="{{ asset_url('admin', 'global/plugins/vuejs/js/vue.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset_url('admin', 'global/plugins/vue-resource/vue-resource.min.js') }}"></script>
	<script type="text/javascript">
		$(function() {
			$('.product-browser-open').productBrowser();
		});
		
		var cart = new Vue({
			el: '#cart',
			data: {
				order_products: [],
			},
			created: function() {
				var app = this;
				@if (isset($order_id))
					this.$http.get(url('api/v1/ecommerce/order/{{ $order_id }}/products')).then(function(res){
						app.order_products = res.body;
					});
				@endif
				document.productBrowser = {
					events: {
						selectProduct: function(info) {
							app.addProduct(info);
						},
					}
				};
			},
			methods: {
				addProduct: function(info) {
					this.order_products.push({
						product_info: {
							id: info.product.id,
							name: info.product.name,
							code: info.product.code,
						},
						options: info.options,
						price: info.price,
						quantity: info.quantity,
					});
					$('#product-browser').modal('hide');
				},
			},
		});
	</script>
@endpush
