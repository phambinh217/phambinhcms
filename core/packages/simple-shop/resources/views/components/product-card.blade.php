<div class="card">
	<a href="{{ route('product.show', ['slug' => $product->slug, 'id' => $product->id]) }}" class="blurring dimmable image">
		@if($product->isSale())
			<span class="ui right corner label red">
				<i class="heart icon"></i>
			</span>
		@endif
		<div class="ui dimmer">
			<div class="content">
				<div class="center">
					<div class="ui inverted button">
						Xem chi tiết
					</div>
				</div>
			</div>
		</div>
		<img src="{{ thumbnail_url($product->thumbnail, ['width' => '400', 'height' => '400']) }}" />
	</a>
	<div class="content">
		<a class="header" href="{{ route('product.show', ['slug' => $product->slug, 'id' => $product->id]) }}">
			{{ $product->name }}
		</a>
		<div class="meta">
			<a>{{ $product->code }}</a>
		</div>
		@if($product->isSale())
			<span class="right floated">
				<s>{{ price_format($product->price) }}</s>
			</span>
			<span class="right floated">
				{{ price_format($product->promotional_price) }}
			</span>
		@else
			<span class="right floated">
				{{ price_format($product->price) }}
			</span>
		@endif
	</div>
	<div class="extra content">
		<div class="ui three buttons">
			<div class="ui basic green button" cart="add" data-rdr="true" data-id="{{ $product->id }}" data-slug="{{ $product->slug }}">Mua ngay</div>
			<div class="ui basic green button" compare="add" data-id="{{ $product->id }}">So sánh</div>
		</div>
	</div>
</div>