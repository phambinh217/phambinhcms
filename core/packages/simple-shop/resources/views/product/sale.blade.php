@extends('Home::layouts.product-filter', [
	'page_title' => 'Giảm giá',
	'product_filter' => [
		'form_action' => route('product.sale'),
		'support' => ['search', 'price', 'category', 'filter', 'tag', 'brand'],
		'filter' => $filter,
	],
])

@section('breadcrumb')
	<div class="ui massive breadcrumb">
		<a class="section" href="{{ url('/') }}">Trang chủ</a>
		<i class="right chevron icon divider"></i>
		<a class="section active">Giảm giá</a>
	</div>
@endsection

@section('product')
	<div class="ui special three cards doubling stackable">
		@foreach($products as $product_item)
			@include('Home::components.product-card', [
				'product' => $product_item
			])
		@endforeach
	</div>
@endsection

@section('paginate')
	{{ $products->render() }}
@endsection