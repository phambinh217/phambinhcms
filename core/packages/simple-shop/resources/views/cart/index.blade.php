@extends('Home::layouts.default')

@section('content')
	<div class="ui container">
		<div class="ui massive breadcrumb">
			<a class="section" href="{{ url('/') }}">Trang chủ</a>
			<i class="right chevron icon divider"></i>
			<a class="section active">Giỏ hàng</a>
		</div>
		@if(\Cart::count())
			<form ajax-form action="{{ route('cart.update-many') }}" method="post">
				{{ csrf_field() }}
				<table class="ui celled padded table">
					<thead>
						<tr>
							<th>#</th>
							<th>Ảnh</th>
							<th>Sản phẩm</th>
							<th>Số lượng</th>
							<th>Đơn giá</th>
							<th>Thành tiền</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						@foreach(\Cart::content() as $cart_item)
							@php $product_item = $products->where('id', $cart_item->id)->first(); @endphp
							<tr>
								<td>{{ $loop->index + 1 }}</td>
								<td>
				                    <a href="{{ route('product.show', ['slug' => $product_item->slug, 'id' => $product_item->id]) }}">
				                        <img src="{{ thumbnail_url($product_item->thumbnail, ['width' => 74, 'height' => 74]) }}" />
				                    </a>
				                </td>
				                <td>
				                    <a href="{{ route('product.show', ['slug' => $product_item->slug, 'id' => $product_item->id]) }}">{{ $product_item->name }}</a>
				                    @if(count($cart_item->options))
										<ul class="ui list">
											@foreach($cart_item->options as $option_id => $value_id)
			                                    @php
		                                            $option = \DB::table('product_to_option_value')
		                                            ->distinct()
		                                            ->select('options.name', 'option_values.value')
		                                            ->join('option_values', 'product_to_option_value.value_id', '=', 'option_values.id')
		                                            ->join('options', 'product_to_option_value.option_id', 'options.id')
		                                            ->where('options.id', $option_id)
		                                            ->whereIn('product_to_option_value.value_id', (array) $value_id)
		                                            ->get();
		                                        @endphp
		                                        <li>{{ $option->first()->name }}: {{ $option->implode('value', ', ') }}</li>
			                                @endforeach
										</ul>
				                    @endif
				                </td>
				                <td>
				                	<input type="hidden" name="product[{{ $loop->index }}][rowId]" value="{{ $cart_item->rowId }}" />
				                	<div class="ui form">
				                		<input type="text" name="product[{{ $loop->index }}][quantity]" value="{{ $cart_item->qty }}"/>
				                	</div>
				                </td>
				                <td>{{ price_format($cart_item->price) }}</td>
				                <td>{{ price_format($cart_item->price * $cart_item->qty) }}</td>
				                <td>
				                    <button data-refresh="true" cart="remove" data-rowid="{{ $cart_item->rowId }}" class="ui icon button negative" data-tooltip="Xóa khỏi giỏ hàng" data-position="bottom left" data-inverted>
				                        <i class="remove icon"></i>
				                    </button>
				                </td>
							</tr>
						@endforeach
					</tbody>
					<tfoot class="full-width">
						<tr>
							<th colspan="3">
								<button type="submit" class="ui left floated small primary labeled icon button">
									<i class="cart icon"></i> Cập nhật giỏ hàng
								</button>
							</th>
							<th>{{ \Cart::count() }}</th>
							<th colspan="3">
								{{ price_format(\Cart::subtotal()) }}
							</th>
						</tr>
					</tfoot>
				</table>
			</form>
		@else
			<h1 class="ui header">
				Giỏ hàng trống
			</h1>
			<div class="sub header">Hãy <a href="{{ url('/') }}">quay lại cửa hàng</a> để mua sản phẩm</div>
		@endif
		<div class="ui clearing segment">
			<a href="{{ url('/') }}" class="ui labeled icon button left floated">
				<i class="chevron left icon"></i>
				Tiếp tục mua
			</a>
			<a href="{{ route('checkout.index') }}" class="ui labeled icon button right floated positive">
		        <i class="checkmark icon"></i>
		        Thanh toán
		    </a>
		</div>
	</div>
@endsection

@push('js_footer')
<script type="text/javascript">
	$(function(){
		handleAjaxForm('*[ajax-form]', function(res){
			toastr.success(res.message, res.title);
			window.location = document.location.href;
		});
	});
</script>
@endpush