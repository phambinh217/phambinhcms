@extends('Home::layouts.default')

@section('content')
	<div class="ui container">
		<div class="ui massive breadcrumb">
			<a class="section" href="{{ url('/') }}">Trang chủ</a>
			<i class="right chevron icon divider"></i>
			<a class="section active">Trang cá nhân</a>
		</div>
		<h1 class="ui header">
			Lịch sử đơn hàng
		</h1>
		<div class="ui grid">
			<div class="four wide column">
				@include('Home::partials.sidebar-profile')
			</div>
			<div class="twelve wide column">
				<table class="ui celled padded table">
					<thead>
						<th>#</th>
						<th>ID</th>
						<th>Sản phẩm</th>
						<th>Ngày</th>
						<th>Tổng giá trị</th>
						<th>Trạng thái</th>
						<th></th>
					</thead>
					@foreach($orders as $order_item)
						<tr>
							<td>{{ $loop->index + 1 }}</td>
							<td>{{ $order_item->id }}</td>
							<td>
								@foreach($order_item->products as $product_item)
									<a href="{{ route('product.show', ['slug' => $product_item->slug, 'id' => $product_item->id]) }}">{{ $product_item->name }}</a>
									@if(!$loop->last), @endif
								@endforeach
							</td>
							<td>{{ changeFormatDate($order_item->created_at) }}</td>
							<td>{{ $order_item->total }}</td>
							<td>{{ $order_item->status->name }}</td>
							<td>
								<button class="ui button mini" data-id="{{ $order_item->id }}" order-detail>Chi tiết</button>
							</td>
						</tr>
					@endforeach
				</table>
				<!-- # | Ngày | Sản phẩm | Tổng giá trị -->
			
			</div>
		</div>
	</div>
@endsection

@push('html_footer')
<div class="ui modal" id="order-detail-modal">
	 <div class="header">Chi tiết đơn hàng</div>
	<div class="content" id="order-content">

	</div>
	<div class="actions">
		<div class="ui cancel button">Đóng</div>
	</div>
</div>
@endpush

@push('js_footer')
	<script type="text/javascript">
		$(function(){
			$('*[order-detail]').click(function(){
				$('#order-detail-modal').modal('show');
			});
		});
	</script>
@endpush