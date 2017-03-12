@extends('Home::layouts.product-filter', [
	'page_title' => $brand->name,
	'product_filter' => [
		'form_action' => route('product.brand', ['slug' => $brand->slug, 'id' => $brand->id]),
		'support' => ['search', 'price', 'category', 'filter', 'tag', 'sale'],
		'filter' => $filter,
	],
])

@section('breadcrumb')
	<div class="ui massive breadcrumb">
		<a class="section" href="{{ url('/') }}">Trang chủ</a>
		<i class="right chevron icon divider"></i>
		<a class="section active">{{ $brand->name }}</a>
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