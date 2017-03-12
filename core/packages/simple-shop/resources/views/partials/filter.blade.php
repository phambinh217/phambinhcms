@php
	$dbfilters = \Packages\Ecommerce\Filter::with(['products' => function ($query) use ($filters) {
		$query->limit(array_total($filters->pluck('limit')));
	}])->whereIn('id', $filters->pluck('id'))->get();
@endphp

@foreach($dbfilters as $filter_item)
	<h1 class="ui header"><a style="color: #000;" href="{{ route('product.filter', ['slug' => $filter_item->slug, 'id' => $filter_item->id]) }}">{{ $filter_item->name }}</a></h1>
	<div class="ui special four cards doubling stackable" style="margin-bottom: 15px">
		@foreach($filter_item->products->take($filters->where('id', $filter_item->id)->first()['limit']) as $product_item)
			@include('Home::components.product-card', [
				'product' => $product_item
			])
		@endforeach
	</div>
	<div class="text-center">
			<a href="{{ route('product.filter', ['slug' => $filter_item->slug, 'id' => $filter_item->id]) }}" class="ui button primary">Xem hết</a>
		</div>
@endforeach