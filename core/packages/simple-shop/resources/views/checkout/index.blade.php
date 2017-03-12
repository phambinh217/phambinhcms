@extends('Home::layouts.default')

@section('content')
<div class="ui container">
	<div class="ui massive breadcrumb">
		<a class="section" href="{{ url('/') }}">Trang chủ</a>
		<i class="right chevron icon divider"></i>
		<a class="section active">Thanh toán</a>
	</div>
	
	<div class="ui segment">
		<form action="{{ route('checkout.store') }}" method="post" id="form-checkout">
			{{ csrf_field() }}
			<div class="ui accordion">
				<div class="title active">
					<i class="dropdown icon"></i>
					Thông tin người nhận
				</div>
				<div class="content active">
					<div class="ui form">
						<div class="fields">
							<div class="field">
								<label>Họ và tên đệm</label>
								<input type="text" placeholder="Họ và tên đệm" name="checkout[last_name]" data-model="last_name" value="{{ \Auth::user()->last_name }}">
							</div>
							<div class="field">
								<label>Tên</label>
								<input type="text" placeholder="Họ và tên tên" name="checkout[first_name]" data-model="first_name" value="{{ \Auth::user()->first_name }}">
							</div>
							<div class="field">
								<label>Số điện thoại</label>
								<input type="text" name="checkout[phone]" placeholder="Số điện thoại" data-model="phone" value="{{ \Auth::user()->phone }}">
							</div>
							<div class="field">
								<label>Email</label>
								<input type="text" name="checkout[email]" placeholder="Email" data-model="email" value="{{ \Auth::user()->email }}">
							</div>
						</div>
						<div class="field">
							<label>Địa chỉ nhận hàng</label>
							<p>Vui lòng ghi chi tiết. Chúng tôi sẽ gửi hàng cho bạn theo địa chỉ này</p>
							<textarea name="checkout[address]" data-model="address">{{ \Auth::user()->address }}</textarea>
						</div>
						<div data-step="2" class="ui submit button">Bước tiếp theo</div>
					</div>
				</div>
				<div class="title step-2">
					<i class="dropdown icon"></i>
					Xác nhận đơn hàng
				</div>
				<div class="content">
					<table class="ui definition celled table">
						<tbody>
							<tr>
								<td>Thông tin người nhận</td>
								<td>
									<ul>
										<li>Tên: <span data-yield="last_name"></span> <span data-yield="first_name"></span></li>
										<li>Số điện thoại: <span data-yield="phone"></span></li>
										<li>Email: <span data-yield="email"></span></li>
										<li>Địa chỉ nhận hàng: <span data-yield="address"></span></li>
									</ul>
								</td>
							</tr>
							<tr>
								<td>Sản phẩm</td>
								<td>
									<table class="ui collapsing celled table">
										<tbody>
											@php $products = \Packages\Ecommerce\Product::whereIn('id', \Cart::content()->pluck('id'))->get(); @endphp
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
														<div class="ui form">
															x{{ $cart_item->qty }}
														</div>
													</td>
													<td>{{ price_format($cart_item->price) }}</td>
												</tr>
											@endforeach
										</tbody>
									</table>
								</td>
							</tr>
							<tr>
								<td>Ghi chú</td>
								<td>
									<p>Ghi chú của bạn đối với đơn hàng</p>
									<div class="ui form">
										<div class="field">
											<textarea name="checkout[comment]" rows="2"></textarea>
										</div>
									</div>
								</td>
							</tr>
							<tr>
								<td>Thành tiền</td>
								<td>
									<table class="ui collapsing celled table">
										<tbody>
											<tr>
												<td>Tổng giá trị sản phẩm</td>
												<td>{{ price_format(\Cart::subtotal()) }}</td>
											</tr>
											<tr>
												<td>Tổng tiền thanh toán bao gồm thuế</td>
												<td>{{ price_format(\Cart::total()) }}</td>
											</tr>
										</tbody>
									</table>
								</td>
							</tr>
						</tbody>
					</table>
					<div data-step="3" class="ui submit button">Bước tiếp theo</div>
				</div>
				<div class="title step-3">
					<i class="dropdown icon"></i>
					Chấp nhận điều khoản và thanh toán
				</div>
				<div class="content">
					<div class="ui ignored info message">
						<h4 class="ui header">Điều khoản</h4>
						<p>Three common ways for a prospective owner to acquire a dog is from pet shops, private owners, or shelters.</p>
						<p>A pet shop may be the most convenient way to buy a dog. Buying a dog from a private owner allows you to assess the pedigree and upbringing of your dog before choosing to take it home. Lastly, finding your dog from a shelter, helps give a good home to a dog who may not find one so readily.</p>
					</div>
					<button type="submit" class="ui submit button positive">Chấp nhận điều khoản và thanh toán</button>
				</div>
			</div>
		</form>
	</div>
</div>	
@endsection

@push('js_footer')
	<script type="text/javascript">
		$(function(){
			handleAjaxForm('#form-checkout', function(res){
				// window.location = url('checkout/success');
			});
			$('.accordion').accordion({
				selector: {
					trigger: '.title'
				}
			});
			$('*[data-step]').click(function(e){
				e.preventDefault();
				var step = $(this).attr('data-step');
				$('.step-'+step).trigger('click');
			});

			function render(container) {
				var name = $(container).attr('data-model');
				var content = $(container).val();
				$('*[data-yield="'+name+'"]').html(content);
			}

			$('*[data-model]').each(function(key, item){
				render(this);	
			});

			$('*[data-model]').keyup(function(){
				render(this);
			});
		});
	</script>
@endpush