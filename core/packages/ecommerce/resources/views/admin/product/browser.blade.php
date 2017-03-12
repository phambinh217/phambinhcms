@extends('Cms::layouts.blank')

@section('blank.main')
	<div class="row" id="product-browser">
		<div class="col-sm-4">
			<div class="portlet light bordered">
	            <div class="portlet-body">
	                <form role="form">
	                    <div class="form-group">
	                        <input type="text" class="form-control" placeholder="Tên sản phẩm" v-model="keyword">
	                    </div>
	                   <button @click.prevent="searchProduct" class="btn blue">Tìm kiếm</button>
	                </form>
	                <div class="scroller" style="height: 70vh;" data-always-visible="1" data-rail-visible1="1">
	                	<table class="table table-hover table-light">
	                		<tbody>
	                			<tr v-for="(product, index) in results" :key="product.id">
	                				<td style="cursor: pointer;" @click="setProductId(product.id)">
	                					<div class="media">
	                						<div class="pull-left">
	                							<img class="img-circle" :src="product.thumbnail" alt="" style="max-width: 70px">
	                						</div>

	                						<div class="media-body">
	                							<ul class="info unstyle-list">
	                								<li class="name">
	                									<a target="_blank" href="javascript:;"><strong>@{{ product.name }}</strong></a>
	                								</li>
	                								<li>Mã: @{{ product.code }}</li>
	                								<li>
                										<div v-if="product.promotional_price != 0">
                											Giá: <strong><s>@{{ product.price }}</s> @{{ product.promotional_price }}</strong>
                										<div>
                										<div v-if="product.promotional_price == 0">
                											Giá: <strong>
                												@{{ product.price }}
                											</strong>
                										</div>
	                								</li>
	                							</ul>
	                						</div>
	                					</div>
	                				</td>
	                			</tr>
	                		</tbody>
	                	</table>
	                </div>
	            </div>
	        </div>
		</div>
		<div class="col-sm-8" style="padding: 15px; margin-left: -15px">
			<div v-if="product_id != null">
				<div class="row">
					<div class="col-sm-6">
						<img :src="product.thumbnail" class="img-responsive" />
					</div>
					<div class="col-sm-6">
						<h4>@{{ product.name }}</h4>
						<div v-if="product.promotional_price != 0">
							<h3>Giá: <s>@{{ product.price }}</s> @{{ product.promotional_price }}</h3>
						<div>
						<div v-if="product.promotional_price == 0">
							<h3>Giá:  @{{ product.price }}</h3>
						</div>
						<div v-for="option_item in options" v-if="options != null">
							<div v-if="option_item.type == 'select'">
								<div class="form-group">
									<label>@{{ option_item.name }} <span v-if="option_item.required == 1" class="required">*</span></label>
									<select name="" class="form-control" v-model="product_option[option_item.option_id]">
										<option></option>
										<option v-for="value_item in option_item.value" :value="value_item.value_id">@{{ value_item.option_value }} (@{{ value_item.prefix + value_item.price }})</option>
									</select>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label>Số lượng</label>
							<input type="number" v-model="product_quantity" class="form-control" />
						</div>
						<button @click.prevent="selectProduct" class="btn btn-primary">Chọn</button>
					</div>
				</div>
			</div>
			<div v-if="product_id == null">

			</div>
		</div>
	</div>         
@endsection

@push('blank.js_footer')
	<script type="text/javascript" src="{{ asset_url('admin', 'global/plugins/vuejs/js/vue.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset_url('admin', 'global/plugins/vue-resource/vue-resource.min.js') }}"></script>
	<script type="text/javascript">
		new Vue({
			'el': '#product-browser',
			data: {
				keyword: null,
				results: [],
				product_id: null,
				product: null,
				options: null,
				product_option: [],
				product_quantity: 1,
			},
			methods: {
				searchProduct: function() {
					if (this.keyword != null) {
						var app = this;
						this.$http.get(url('api/v1/ecommerce/product'),{params: {_keyword: this.keyword}}).then(function(res) {
							app.results = res.body;
						});
					} else {
						alert('Vui lòng nhập tên sản phẩm để tìm kiếm');
					}
				},

				findProduct: function(product_id) {
					var product;
					this.results.forEach(function(item, index) {
						if (item.id == product_id) {
							product = item;
						}
					});
					return product;
				},

				setProductId: function(product_id) {
					var app = this;
					this.product_id = product_id;
					this.product = this.findProduct(this.product_id);
					this.$http.get(url('api/v1/ecommerce/product/'+this.product_id+'/options')).then(function(res) {
						app.options = res.body;
						app.options.forEach(function (item, index) {
							app.product_option[item.option_id] = null;
						});
					});
				},

				findOption: function(option_id) {
					var option;
					this.options.forEach(function(item, index) {
						if (item.option_id == option_id) {
							option = item;
						}
					});
					return option;
				},

				findValue: function() {

				},
				
				calPrice: function(product_option) {
					var product = this.product;
					
					if (product.promotional_price != 0) {
						var price = product.promotional_price;
					} else {
						var price = product.price;
					}

					product_option.forEach(function(item, index) {
						if (item.prefix == '+') {
							price = price + item.price;
						} else {
							price = price - item.price;
						}
					});

					return price;
				},

				selectProduct: function() {
					if (this.product_id != null) {
						var app = this;
						var product = this.findProduct(this.product_id);
						var product_option = [];

						this.product_option.forEach(function (value_id, option_id) {
							if (value_id) {
								var option = app.findOption(option_id);
								var value;
								option.value.forEach(function(value_item, index) {
									if (value_item.value_id == value_id) {
										value = value_item;
									}
								});

								product_option.push({
									id: option.option_id,
									name: option.name,
									value_id: value_id,
									value: value.option_value,
									price: value.price,
									prefix:value.prefix,
								});
							}
						});

						$productBrowser = window.parent.document.productBrowser;

						var info = {
							product: product,
							options: product_option,
							quantity: this.product_quantity,
							price: this.calPrice(product_option),
						}
						$productBrowser.events.selectProduct(info);
					}
				},
			},
		})
	</script>
@endpush