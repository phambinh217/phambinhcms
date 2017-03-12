<h1 class="ui header"><a style="color: #000;" href="{{ route('product.sale') }}">Đang giảm giá</a></h1>
<div class="ui special four cards doubling stackable" style="margin-bottom: 15px">
	@php $products = \Packages\Ecommerce\Product::applyFilter(['sale' => 'true'])->take(setting('page.home.main.sale.limit'))->get(); @endphp
	@foreach($products as $product_item)
		@include('Home::components.product-card', [
			'product' => $product_item
		])
	@endforeach
</div>
<div class="text-center">
	<a href="{{ route('product.sale') }}" class="ui button primary">Xem hết</a>
</div>