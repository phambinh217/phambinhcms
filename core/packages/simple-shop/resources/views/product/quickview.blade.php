@extends('Home::layouts.blank')

@section('main')
<div class="ui container fluid" id="wrapper">
	<h1 class="ui header">
		{{ $product->name }}
		<div class="sub header">
			<div class="ui rating star" data-max-rating="5"></div>
		</div>
	</h1>
	<div class="ui grid">
		<div class="seven wide column" id="height">
			<div class="ui segment image-frame">
				<img width="100%" src="{{ thumbnail_url($product->thumbnail, ['width' => 400, 'height' => 300]) }}" alt="{{ $product->name }}" />
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
				<div class="title title">
					<i class="dropdown icon"></i>
					Thông tin sản phẩm
				</div>
				<div class="content active">
					<p class="">{{ $product->content }}</p>
				</div>
				<div class="title">
					<i class="dropdown icon"></i>
					Cấu hình chi tiết
				</div>
				<div class="content">
					<p class="transition hidden">{{ $product->content }}</p>
				</div>
			</div>
			<button class="ui primary medium icon labeled button" cart="add" data-id="{{ $product->id }}" data-slug="{{ $product->slug }}">
				<i class="cart icon"></i> Mua ngay
			</button>
			<div class="ui divider"></div>
			<div class="ui right aligned">
				@foreach($product->tags()->get() as $tag_item)
					<a class="ui tag label mini">{{ $tag_item->name }}</a>
				@endforeach
			</div>
		</div>
	</div>
</div>
@endsection

@push('js_footer')
<script type="text/javascript">
	$(function(){
		$('.rating').rating({
			initialRating: 2,
			maxRating: 4
		});

		$('.accordion').accordion();
	});
</script>
@endpush