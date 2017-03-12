@extends('Home::layouts.product-filter', [
	'page_title' => 'Kết quả tìm kiếm',
	'product_filter' => [
		'form_action' => route('search'),
		'support' => ['search', 'price', 'brand', 'filter', 'category', 'tag', 'sale'],
		'filter' => $filter,
	],
])

@section('breadcrumb')
	<div class="ui massive breadcrumb">
		<a class="section" href="{{ url('/') }}">Trang chủ</a>
		<i class="right chevron icon divider"></i>
		<a class="section active">Tìm kiếm {{ isset($filter['_keyword']) ? '"' . $filter['_keyword'] . '"' : '' }}</a>
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