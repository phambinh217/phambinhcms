@extends('Home::layouts.default')

@section('content')
	<div class="ui container">
		<h1 class="ui header">
			<a style="color: #000;" href="{{ route('search') }}"">Sản phẩm mới</a>
		</h1>
		@php $products = \Packages\Ecommerce\Product::applyFilter()->paginate(setting('page.home.main.newsest.limit')); @endphp
		<div class="ui special four cards doubling stackable" style="margin-bottom: 15px">
			@foreach($products as $product_item)
				@include('Home::components.product-card', [
					'product' => $product_item
				])
			@endforeach
		</div>
		<div class="text-center">
			<a href="{{ route('search') }}" class="ui button primary">Xem hết</a>
		</div>
		@include('Home::partials.sale')
		@include('Home::partials.filter', ['filters' => collect(setting('page.home.main.filters'))])
	</div>
@endsection

@push('js_footer')
	<script type="text/javascript">
		$(function(){
			$('.special.cards .image').dimmer({
				on: 'hover'
			});
		});
	</script>
@endpush