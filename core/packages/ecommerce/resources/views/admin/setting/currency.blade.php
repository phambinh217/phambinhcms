@extends('Cms::layouts.default',[
	'active_admin_menu' 	=> ['ecommerce.setting', ' ecommerce.setting.currency'],
	'breadcrumbs' 			=> [
		'title'	=> ['Cài đặt', 'Tiền tệ'],
		'url'	=> [route('admin.ecommerce.setting.currency')],
	],
])

@section('page_title', 'Cài đặt tiền tệ')

@section('content')
	<div class="tabbable-line">
		<ul class="nav nav-tabs">
			<li class="active">
				<a href="#default-currency" data-toggle="tab"> Mặc định </a>
			</li>
			<li>
				<a href="#manage-currency" data-toggle="tab"> Quản lí </a>
			</li>
			<li>
				<a href="#new-currency" data-toggle="tab"> Thêm mới </a>
			</li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane fade active in" id="default-currency">
				<form class="form-horizontal ajax-form" method="POST" action="{{ route('admin.ecommerce.setting.currency.update') }}">
					{{ csrf_field() }}
					{{ method_field('PUT') }}
					<div class="form-body">
						<div class="form-group">
							<label class="control-lalel col-sm-3 pull-left">
								Đơn vị tiền tệ sử dụng
							</label>
							<div class="col-sm-3">
								@include('Ecommerce::admin.components.form-select-currency', [
									'currencies' => $currencies,
									'name' => 'default_currency_id',
									'selected' => $default_currency_id
								])
							</div>
						</div>
					</div>
					<div class="form-actions util-btn-margin-bottom-5">
						<button class="btn btn-primary full-width-xs">
							<i class="fa fa-check"></i> Đặt là mặc định
						</button>
					</div>
				</form>
			</div>
			<div class="tab-pane fade" id="manage-currency">
				<div id="app-currency" v-if="all_currencies.length">
					<form  class="form-horizontal ajax-form" method="POST" :action="'{{ admin_url('shop/setting/currency') }}/'+currency_id">
						{{ csrf_field() }}
						{{ method_field('PUT') }}
						<div class="form-body">
							<div class="form-group">
								<label class="control-lalel col-sm-3 pull-left">
									Đơn vị tiền tệ sử dụng
								</label>
								<div class="col-sm-3">
									<select class="form-control" @change="changeCurrency($event)">
										<option v-for="currency in all_currencies" v-bind:selected="currency_id == currency.id ? true : false" :value="currency.id">@{{ currency.name }}</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="control-lalel col-sm-3 pull-left">
									Tên
								</label>
								<div class="col-sm-3">
									<input type="text" name="currency[name]" class="form-control" :value="default_currency.name" />
								</div>
							</div>
							<div class="form-group">
								<label class="control-lalel col-sm-3 pull-left">
									Mã
								</label>
								<div class="col-sm-3">
									<input type="text" name="currency[code]" class="form-control" :value="default_currency.code" />
								</div>
							</div>
							<div class="form-group">
								<label class="control-lalel col-sm-3 pull-left">
									Biểu tượng trái
								</label>
								<div class="col-sm-3">
									<input type="text" name="currency[symbol_left]" class="form-control" :value="default_currency.symbol_left" />
								</div>
							</div>
							<div class="form-group">
								<label class="control-lalel col-sm-3 pull-left">
									Biểu tượng phải
								</label>
								<div class="col-sm-3">
									<input type="text" name="currency[symbol_right]" class="form-control" :value="default_currency.symbol_right" />
								</div>
							</div>
							<div class="form-group">
								<label class="control-lalel col-sm-3 pull-left">
									Sau dấu phẩy
								</label>
								<div class="col-sm-3">
									<input type="text" name="currency[decimal_place]" class="form-control" :value="default_currency.decimal_place" />
								</div>
							</div>
						</div>
						<div class="form-actions util-btn-margin-bottom-5">
							<button class="btn btn-primary full-width-xs">
								<i class="fa fa-check"></i> Lưu
							</button>
							<button class="btn btn-danger full-width-xs" @click.prevent="removeCurrency">
							<i class="fa fa-times"></i> Xóa
						</button>
						</div>
					</form>
				</div>
			</div>
			<div class="tab-pane fade" id="new-currency">
				<form  class="form-horizontal ajax-form" method="POST" action="{{ route('admin.ecommerce.setting.currency.store-currency') }}">
					{{ csrf_field() }}
					<div class="form-body">
						<div class="form-group">
							<label class="control-lalel col-sm-3 pull-left">
								Tên
							</label>
							<div class="col-sm-3">
								<input type="text" class="form-control" name="currency[name]" />
							</div>
						</div>
						<div class="form-group">
							<label class="control-lalel col-sm-3 pull-left">
								Mã
							</label>
							<div class="col-sm-3">
								<input type="text" class="form-control" name="currency[code]" />
							</div>
						</div>
						<div class="form-group">
							<label class="control-lalel col-sm-3 pull-left">
								Biểu tượng trái
							</label>
							<div class="col-sm-3">
								<input type="text" class="form-control" name="currency[symbol_left]" />
							</div>
						</div>
						<div class="form-group">
							<label class="control-lalel col-sm-3 pull-left">
								Biểu tượng phải
							</label>
							<div class="col-sm-3">
								<input type="text" class="form-control" name="currency[symbol_right]"/>
							</div>
						</div>
						<div class="form-group">
							<label class="control-lalel col-sm-3 pull-left">
								Sau dấu phẩy
							</label>
							<div class="col-sm-3">
								<input type="text" class="form-control" name="currency[decimal_place]" />
							</div>
						</div>
					</div>
					<div class="form-actions util-btn-margin-bottom-5">
						<button class="btn btn-primary full-width-xs">
							<i class="fa fa-save"></i> Thêm
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection

@push('css')
	<link href="{{ asset_url('admin', 'global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
@endpush

@push('js_footer')
	<script type="text/javascript" src="{{ asset_url('admin', 'global/plugins/jquery-form/jquery.form.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset_url('admin', 'global/plugins/bootstrap-toastr/toastr.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset_url('admin', 'global/plugins/vuejs/js/vue.min.js') }}"></script>
	<script type="text/javascript">
		var appCurrency = new Vue({
			el: '#app-currency',
			data: {
				currency_id: '{{ ! empty($currency) ? $currency->id : '' }}',
				default_currency: {!! ! empty($currency) ? $currency->toJson() : "{}" !!},
				all_currencies: {!! ! empty($currencies) ? $currencies->toJson() : "[]" !!},
			},
			methods: {
				changeCurrency: function(e) {
					var new_currency_id = e.target.value;
					// console.log("New currency id", new_currency_id);
					this.currency_id = new_currency_id;
					this.default_currency = this.all_currencies.filter(function(item) { return item.id == new_currency_id })[0];
					// console.log("New currency is: ", this.default_currency.name);
				},

				removeCurrency: function() {
					$.ajax({
						url: '{{ admin_url('shop/setting/currency') }}/'+this.currency_id,
						type: 'post',
						data: {
							_method: 'DELETE',
							_token: csrfToken(),
						}
					});
				},
			},
		});
	</script>
@endpush
