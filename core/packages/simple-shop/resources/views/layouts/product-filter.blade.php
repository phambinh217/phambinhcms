@extends('Home::layouts.default')

@section('content')
	<div class="ui container">
		@yield('breadcrumb')
		<h1 class="ui header">{{ $page_title }}</h1>
		<div class="ui grid">
			<div class="four wide column">
				<div class="ui segment product-filter sticky">
					<h3 class="ui header">Bộ lọc</h3>
					@include('Home::partials.product-filter', $product_filter)
				</div>
			</div>
			<div class="twelve wide column product-list">
				@yield('product')
			</div>
		</div>
		<div class="text-center">
			@yield('paginate')
		</div>
	</div>
@endsection

@push('js_footer')
	<script type="text/javascript">
		$(function(){
			$('.ui.product-filter').sticky({
				context: '.product-list',
				offset: 75,
			});
			$('.special.cards .image').dimmer({
				on: 'hover'
			});
		});
	</script>
@endpush