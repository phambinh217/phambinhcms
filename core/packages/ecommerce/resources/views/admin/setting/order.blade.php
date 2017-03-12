@extends('Cms::layouts.default',[
	'active_admin_menu' 	=> ['ecommerce.setting',  'ecommerce.setting.order'],
	'breadcrumbs' 			=> [
		'title'	=> ['Cài đặt', 'Đơn hàng'],
		'url'	=> [route('admin.ecommerce.setting.order')],
	],
])

@section('page_title', 'Cài đặt đơn hàng')

@section('content')
	<div class="tabbable-line">
		<ul class="nav nav-tabs ">
			<li class="active">
				<a href="#order-setting" data-toggle="tab"> Cài đặt </a>
			</li>
			<li>
				<a href="#manage-order-status" data-toggle="tab"> Quản lí trạng thái </a>
			</li>
			<li>
				<a href="#new-order-status" data-toggle="tab"> Thêm trạng thái mới </a>
			</li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane active" id="order-setting">
				<form class="form-horizontal ajax-form" method="POST" action="{{ route('admin.ecommerce.setting.order.update') }}">
					{{ csrf_field() }}
					{{ method_field('PUT') }}
					<div class="form-body">
						<div class="form-group">
							<label class="control-lalel col-sm-3 pull-left">
								Yêu cầu khách hàng xác nhận đơn hàng qua email
							</label>
							<div class="col-sm-9">
								<select name="confirm_order" class="form-control width-auto" id="confirm-order">
									@foreach([['id' => 'false', 'name' => 'Không'], ['id' => 'true', 'name' => 'Có']] as $option_item)
										<option {{ $confirm_order == $option_item['id'] ? 'selected' : '' }} value="{{ $option_item['id'] }}">{{ $option_item['name'] }}</option>
									@endforeach
								</select>
								<p class="help-block">
									
								</p>
							</div>
						</div>
						<div class="form-group" id="order-status-not-confirm" {!! $confirm_order == 'true' ? '' : 'style="display: none"' !!}>
							<label class="control-lalel col-sm-3 pull-left">
								Trạng thái đơn hàng khi đang chờ xác nhận
							</label>
							<div class="col-sm-9">
								@include('Ecommerce::admin.components.form-select-order-status', [
									'name' => 'order_status_not_confirm',
									'selected' => $order_status_not_confirm,
									'class' => 'width-auto',
									'statuses' => \Packages\Ecommerce\OrderStatus::get(),
								])
								<p class="help-block">
									
								</p>
							</div>
						</div>
					</div>
					<div class="form-body">
						<div class="form-group">
							<label class="control-lalel col-sm-3 pull-left">
								Gửi thông báo đến quản trị viên khi có đơn hàng
							</label>
							<div class="col-sm-9">
								<select name="order_notify_email" id="order-notify-email" class="form-control width-auto">
									@foreach([['id' => 'false', 'name' => 'Không'], ['id' => 'true', 'name' => 'Có']] as $option_item)
										<option {{ $order_notify_email == $option_item['id'] ? 'selected' : '' }} value="{{ $option_item['id'] }}">{{ $option_item['name'] }}</option>
									@endforeach
								</select>
								<p class="help-block">
									
								</p>
							</div>
						</div>
						<div class="form-group" id="order-notify-email-user-role" {!! $order_notify_email == 'true' ? '' : 'style="display: none"' !!}>
							<label class="control-lalel col-sm-3 pull-left">
								Địa chỉ mail thông báo cho quản trị viên được gửi đến
							</label>
							<div class="col-sm-3">
								<input type="text" class="form-control" value="{{ $order_notify_email_to }}" />
								<p class="help-block">
									
								</p>
							</div>
						</div>
						<div class="form-group">
							<label class="control-lalel col-sm-3 pull-left">
								Trạng thái đầu tiên của đơn hàng
							</label>
							<div class="col-sm-9">
								@include('Ecommerce::admin.components.form-select-order-status', [
									'name' => 'default_order_status_id',
									'selected' => $default_order_status_id,
									'class' => 'width-auto',
									'statuses' => \Packages\Ecommerce\OrderStatus::get(),
								])
								<p class="help-block">
									
								</p>
							</div>
						</div>
					</div>
					<div class="form-actions util-btn-margin-bottom-5">
						<button class="btn btn-primary full-width-xs">
							<i class="fa fa-save"></i> Lưu cài đặt
						</button>
					</div>
				</form>
			</div>
			<div class="tab-pane" id="manage-order-status">
				<div v-if="all_order_statuses.length">
					<form class="form-horizontal ajax-form" method="POST" :action="'{{ admin_url('ecommerce/setting/order-status') }}/'+order_status_id">
						{{ csrf_field() }}
						{{ method_field('PUT') }}
						<div class="form-body">
							<div class="form-group">
								<label class="control-lalel col-sm-3 pull-left">
									Chọn trạng thái
								</label>
								<div class="col-sm-3">
									<select class="form-control" @change="changeOrderStatus($event)">
										<option v-for="order_status in all_order_statuses" v-bind:selected="order_status_id == order_status.id ? true : false" :value="order_status.id">@{{ order_status.name }}</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="control-lalel col-sm-3 pull-left">
									Tên
								</label>
								<div class="col-sm-3">
									<input type="text" name="order_status[name]" class="form-control" :value="order_status.name" />
								</div>
							</div>
							<div class="form-group">
								<label class="control-lalel col-sm-3 pull-left">
									Chú thích
								</label>
								<div class="col-sm-6">
									<textarea name="order_status[comment]" class="form-control">@{{ order_status.comment }}</textarea>
								</div>
							</div>
						</div>
						<div class="form-actions util-btn-margin-bottom-5">
							<button class="btn btn-primary full-width-xs">
								<i class="fa fa-check"></i> Lưu
							</button>
							<button class="btn btn-danger full-width-xs" @click.prevent="removeOrderStatus">
								<i class="fa fa-times"></i> Xóa
							</button>
						</div>
					</form>
				</div>
			</div>
			<div class="tab-pane" id="new-order-status">
				<form class="form-horizontal ajax-form" method="POST" action="{{ route('admin.ecommerce.setting.order-status.store') }}">
					{{ csrf_field() }}
					<div class="form-body">
						<div class="form-group">
							<label class="control-lalel col-sm-3 pull-left">
								Tên
							</label>
							<div class="col-sm-3">
								<input type="text" name="order_status[name]" class="form-control" value="" />
							</div>
						</div>
						<div class="form-group">
							<label class="control-lalel col-sm-3 pull-left">
								Chú thích
							</label>
							<div class="col-sm-6">
								<textarea name="order_status[comment]" class="form-control"></textarea>
							</div>
						</div>
					</div>
					<div class="form-actions util-btn-margin-bottom-5">
						<button class="btn btn-primary full-width-xs">
							<i class="fa fa-check"></i> Thêm trạng thái mới
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
		new Vue({
			el: '#manage-order-status',
			data: {
				order_status_id: '{{ $default_order_status_id }}',
				order_status: {!! ! empty($order_status) ? $order_status->toJson() : "[]" !!},
				all_order_statuses: {!! ! $order_statuses->isEmpty() ? $order_statuses->toJson() : "[]" !!},
			},
			methods: {
				changeOrderStatus: function(e) {
					var new_order_status_id = e.target.value;
					this.order_status_id = new_order_status_id;
					this.order_status = this.all_order_statuses.filter(function(item) { return item.id == new_order_status_id })[0];
				},

				removeOrderStatus: function() {
					$.ajax({
						url: '{{ admin_url('ecommerce/setting/order-status') }}/'+this.order_status_id,
						type: 'post',
						data: {
							_method: 'DELETE',
							_token: csrfToken(),
						}
					});
				},
			},
		});

		$(function(){
			$('#confirm-order').change(function(){
    			if ($(this).val() == 'true') {
    				$('#order-status-not-confirm').show();
    			} else {
    				$('#order-status-not-confirm').hide();
    			}
    		});

			$('#order-notify-email').change(function(){
    			if ($(this).val() == 'true') {
    				$('#order-notify-email-user-role').show();
    			} else {
    				$('#order-notify-email-user-role').hide();
    			}
    		});
		});
	</script>
@endpush
