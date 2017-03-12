@extends('Cms::layouts.default',[
	'active_admin_menu' 	=> ['sales.order', 'sales.order.index'],
	'breadcrumbs' 			=> [
		'title'	=> ['Đơn hàng', 'Chi tiết'],
		'url'	=> [route('admin.ecommerce.order.index')],
	],
])

@section('page_title', 'Xem đơn hàng')
@section('tool_bar')
	<a class="btn btn-primary" onclick="javascript:window.print();">
		<i class="fa fa-print"></i> <span class="hidden-xs">In</span>
	</a>
	<a class="btn btn-primary" href="{{ route('admin.ecommerce.order.edit', ['id' => $order->id]) }}">
		<i class="fa fa-pencil-square-o"></i> <span class="hidden-xs">Chỉnh sửa</span>
	</a>
@endsection
@section('content')
<div class="portlet light portlet-fit bordered">
	<div class="portlet-title">
        <div class="caption">
            <i class="fa fa-ticket"></i>
            <span class="caption-subject uppercase"> Đơn hàng (#{{$order->id}}) </span>
        </div>
        <div class="actions">
        	<form action="{{ route('admin.ecommerce.order.change-status', ['id' => $order->id]) }}" form-order-status method="post" class="ajax-form">
        		{{ method_field('put') }}
	        	@include('Ecommerce::admin.components.form-select-order-status', [
	        		'name' => 'status_id',
	        		'attributes' => 'id="order-status"',
	        		'selected' => $order->status_id,
	        		'statuses' => \Packages\Ecommerce\OrderStatus::get(),
	        	])
        	</form>
        </div>
    </div>
	<div class="portlet-body">
		<div class="row invoice-head">
			<div class="col-xs-6">
				<div class="invoice-logo">
					<img src="{{ url('logo.png') }}" class="img-responsive" alt="">
				</div>
			</div>
			<div class="col-xs-6 text-right">
				<div class="company-address">
					<span class="bold uppercase">{{ setting('company-name') }}.</span><br />
					{!! setting('company-address') !!}<br />
					<span class="bold">T</span> {{ setting('company-phone') }}
					<br>
					<span class="bold">E</span> {{ setting('company-email') }}
					<br>
					<span class="bold">W</span> {{ url('/') }} </div>
				</div>
			</div>
		<div class="row invoice-cust-add">
			<div class="col-xs-3">
				<h5 class="invoice-title uppercase">Tài khoản đặt hàng</h5>
				<p class="invoice-desc">
					<img src="{{ thumbnail_url($order->customer->avatar, ['width' => 32, 'height' => 32]) }}" class="img-circle" /> {{ $order->customer->full_name }}
				</p>
			</div>
			<div class="col-xs-3">
				<h5 class="invoice-title uppercase">Ngày giờ</h5>
				<p class="invoice-desc">{{ $order->created_at }}</p>
			</div>
			<div class="col-xs-6">
				<h5 class="invoice-title uppercase">Địa chỉ nhận hàng</h5>
				<p class="invoice-desc inv-address">
					<strong>Họ và tên</strong>: {{ $order->last_name .' '. $order->first_name }} <br />
					<strong>Email</strong>: {{ $order->email }} <br />
					<strong>Phone</strong>: {{ $order->phone }} <br />
					<strong>Địa chỉ nhận hàng</strong>:  {{ $order->address }}
				</p>
			</div>
		</div>
		<table class="table table-bordered">
			<thead>
				<tr>
					<th class="text-left">Sản phẩm</th>
					<th class="text-left">Mã sản phẩm</th>
					<th class="text-right">Số lượng</th>
					<th class="text-right">Đơn giá</th>
					<th class="text-right">Tổng tiền</th>
				</tr>
			</thead>
			<tbody>
				@foreach($order->products as $product_item)
					<tr>
						<td class="text-left">
							<a href="">{{ $product_item->name }}</a> <br />
							@if($order->productOptions->count())
								@php $options = $order->productOptions->groupBy('option_id'); @endphp
								@foreach($options as $option_item)
									<small>{{ $option_item->first()->name }}: {{ $option_item->implode('value', ', ') }}</small><br />
								@endforeach
	                        @endif
						</td>
						<td class="text-left">{{ $product_item->code }}</td>
						<td class="text-right">{{ $product_item->quantity }}</td>
						<td class="text-right">{{ price_format($product_item->price) }}</td>
						<td class="text-right">{{ price_format($product_item->quantity * $product_item->price) }}</td>
					</tr>
				@endforeach
				@foreach($order->details as $detail_item)
					<tr>
						<td colspan="4" class="text-right">{{ $detail_item->name }}</td>
						<td class="text-right">{{ price_format($detail_item->value) }}</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
@endsection

@push('css')
	<link href="{{ asset_url('admin', 'global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
@endpush

@push('js_footer')
	<script type="text/javascript" src="{{ asset_url('admin', 'global/plugins/jquery-form/jquery.form.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset_url('admin', 'global/plugins/bootstrap-toastr/toastr.min.js') }}"></script>
	<script type="text/javascript">
		$(function(){
			$('#order-status').change(function(){
				$('*[form-order-status]').submit();
			});
		});
	</script>
@endpush
