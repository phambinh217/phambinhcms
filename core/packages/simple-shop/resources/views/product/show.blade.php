@extends('Home::layouts.default')

@section('content')
	<div class="ui container">
		<div class="ui massive breadcrumb">
			<a class="section" href="{{ url('/') }}">Trang chủ</a>
			<i class="right chevron icon divider"></i>
			<a class="section active">{{ $product->name }}</a>
		</div>
		<h1 class="ui header">
			{{ $product->name }}
			<div class="sub header">
				<div class="ui rating star" data-max-rating="5"></div>
			</div>
		</h1>
		<div class="ui grid">
			<div class="seven wide column" id="height">
				<div class="ui segment image-frame image-zoom">
					<img width="100%" src="{{ $product->thumbnail }}" alt="{{ $product->name }}" class="image-big" />
				</div>
				<div class="ui grid owl-carousel">
					@foreach($product->images()->get() as $image_item)
						<div class="image-thumb" class="ten wide column">
							<img src="{{ $image_item->url }}" class="image" />
						</div>
					@endforeach
				</div>
			</div>
			<div class="nine wide column">
				<div class="ui clearing">
					@if($product->isSale())
						<span class="ui header red huge">
							{{ price_format($product->promotional_price) }}
						</span>
						<span class="ui header">
							<s>{{ price_format($product->price) }}</s>
						</span>
					@else
						<span class="ui header red huge">
							{{ price_format($product->price) }}
						</span>
					@endif
					<div class="ui right floated header">
						@if($product->inStock())
							Còn hàng
						@else
							Hết hàng
						@endif
					</div>
				</div>		
				<div class="ui divider"></div>
				<div class="ui accordion bottom-20">
					<div class="title active">
						<i class="dropdown icon"></i>
						Thông tin sản phẩm
					</div>
					<div class="content active">
						<p class="">{!! $product->content !!}</p>
					</div>
					<div class="title">
						<i class="dropdown icon"></i>
						Cấu hình chi tiết
					</div>
					<div class="content">
						<p class="transition hidden">
							<table class="ui collapsing celled table">
								<tbody>
									@foreach($product->attributes()->get() as $attribute_item)
										<tr>
											<td class="active">{{ $attribute_item->name }}</td>
											<td>{{ $attribute_item->pivot->value }}</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</p>
					</div>
				</div>		
				<div class="ui horizontal divider">
					Đặt hàng ngay
				</div>
				<div class="ui grid">
					<div class="ten wide column">
						<form ajax-form class="ui form" action="{{ route('cart.store') }}" method="post">
							{{ csrf_field() }}
							<input type="hidden" name="product_id" value="{{ $product->id }}" />
							@if($product->options->count())
			                    @foreach($product->options as $option_item)
			                        @include('Home::components.product-form-option.'.$option_item->type, [
			                            'name'  		=> 'product[option]['. $option_item->id .']',
			                            'option'  		=> $option_item,
			                            'product'		=> $product,
			                        ])
			                    @endforeach
			                @endif
			                <div class="inline fields">
			                	<div class="ui three wide field">
			                		<input type="text" name="quantity" placeholder="Số lượng" value="1" />
			                	</div>
			                	<div class="thirteen wide field">
			                		<button class="ui primary icon labeled button">
			                			<i class="cart icon"></i> Mua ngay
			                		</button>
			                		<button compare="add" data-id="{{ $product->id }}" class="ui icon labeled button">
			                			<i class="cart icon"></i> So sánh
			                		</button>
			                	</div>
			                </div>
						</form>
					</div>
					<div class="six wide column">
						@include('Home::partials.step', ['type' => 'vertical', 'active' => '1'])
					</div>
				</div>

				<div class="ui divider"></div>
				@if($product->tags->count())
					<div class="ui right aligned">
						@foreach($product->tags as $tag_item)
							<a href="{{ route('product.tag', ['slug' => $tag_item->slug, 'id' => $tag_item->id]) }}" class="ui tag label mini">{{ $tag_item->name }}</a>
						@endforeach
					</div>
				@endif
			</div>
		</div>
		<div class="ui top attached tabular menu">
			<a class="item active" data-tab="first">Đánh giá chi tiết</a>
			<a class="item" data-tab="second">Bình luận</a>
		</div>
		<div class="ui bottom attached tab segment active" data-tab="first">
			Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
			tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
			quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
			consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
			cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
			proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
		</div>
		<div class="ui bottom attached tab segment" data-tab="second">
			Second
		</div>
		@include('Home::partials.product-related', ['product' => $product])
	</div>
@endsection

@push('js_footer')
<script type="text/javascript">
	$(function(){
		$('.rating').rating({
			initialRating: 2,
			maxRating: 4
		});
		$('.image-zoom').zoom();
		$('.accordion').accordion();
		$('.owl-carousel').owlCarousel({
			loop:true,
			margin:10,
			nav:false,
		});
		$('.image-thumb').click(function(){
			url = $('img',this).attr('src');
			$('.image-big').attr('src', url);
			$('.image-zoom').zoom({
				url: url
			});
		});
		$('.menu .item').tab();
		handleAjaxForm('*[ajax-form]', function(res){
			addProductNotice(res.title, '<img src="'+res.thumbnail+'" />', res.message);
            updateViewCart(res);
		});
	});
</script>
@endpush