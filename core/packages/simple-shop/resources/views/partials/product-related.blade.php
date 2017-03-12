<h1 class="ui header">Sản phẩm liên quan</h1>
@php $products = $product->relates()->take(4)->get(); @endphp
<div class="ui special four cards doubling stackable">
	@foreach($products as $product_item)
		@include('Home::components.product-card', [
			'product' => $product_item
		])
	@endforeach
</div>

@push('js_footer')
	<script type="text/javascript">
		$(function(){
			$('.special.cards .image').dimmer({
				on: 'hover'
			});
		});
	</script>
@endpush