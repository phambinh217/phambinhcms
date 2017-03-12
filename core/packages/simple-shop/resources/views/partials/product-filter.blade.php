<form class="ui form" action="{{ $form_action }}">
	@if(in_array('search', $support))
		<div class="field">
			<input type="text" name="_keyword" placeholder="Tên sản phẩm" value="{{ $filter['_keyword'] or '' }}" />
		</div>
	@endif
	
	@if(in_array('price', $support))
		<div class="field">
			<div class="ui fluid search selection dropdown filter-price">
				<input type="hidden" name="price">
				<i class="dropdown icon"></i>
				<div class="default text">Mức giá</div>
				<div class="menu">
					<div class="item" data-value="0">Tất cả</div>
					@foreach(setting('price-levels') as $level_item)
						<div class="item" data-value="{{ $level_item['value'] }}">{{ $level_item['name'] }}</div>
					@endforeach
				</div>
			</div>
		</div>
	@endif
	
	@if(in_array('category', $support))
		<div class="field">
			<div class="ui fluid search selection dropdown filter-category">
				<input type="hidden" name="category_id">
				<i class="dropdown icon"></i>
				<div class="default text">Loại sản phẩm</div>
				<div class="menu">
					@php $catgories = Packages\Ecommerce\Category::select('id', 'name')->get(); @endphp
					<div class="item" data-value="0">Tất cả</div>
					@foreach($catgories as $category_item)
						<div class="item" data-value="{{ $category_item->id }}">
							{{ $category_item->name }}
						</div>
					@endforeach
				</div>
			</div>
		</div>
	@endif
	
	@if(in_array('brand', $support))
		<div class="field">
			<div class="ui fluid search selection dropdown filter-brand">
				<input type="hidden" name="brand_id">
				<i class="dropdown icon"></i>
				<div class="default text">Thương hiệu</div>
				<div class="menu">
					@php $brands = Packages\Ecommerce\Brand::select('id', 'name')->get(); @endphp
					<div class="item" data-value="0">Tất cả</div>
					@foreach($brands as $brand_item)
						<div class="item" data-value="{{ $brand_item->id }}">
							{{ $brand_item->name }}
						</div>
					@endforeach
				</div>
			</div>
		</div>
	@endif

	@if(in_array('filter', $support))
		<div class="field">
			<div class="ui fluid search selection dropdown filter-filter">
				<input type="hidden" name="filter_id">
				<i class="dropdown icon"></i>
				<div class="default text">Bộ lọc</div>
				<div class="menu">
					@php $filters = Packages\Ecommerce\Filter::select('id', 'name')->get(); @endphp
					<div class="item" data-value="0">Tất cả</div>
					@foreach($filters as $filter_item)
						<div class="item" data-value="{{ $filter_item->id }}">
							{{ $filter_item->name }}
						</div>
					@endforeach
				</div>
			</div>
		</div>
	@endif
	
	@if(in_array('tag', $support))
		<div class="field">
			<div class="ui fluid selection dropdown search filter-tag">
				<input name="tag_id" type="hidden">
				<i class="dropdown icon"></i>
				<div class="default text">Thẻ</div>
				<div class="menu">
					
				</div>
			</div>
		</div>
	@endif

	@if(in_array('sale', $support))
		<div class="inline field">
			<div class="ui checkbox filter-sale">
				<input name="sale" type="checkbox" tabindex="0" class="hidden" value="true" {{ isset($filter['sale']) && $filter['sale'] == 'true' ? 'checked' : '' }}/>
				<label>Đang giảm giá</label>
			</div>
		</div>
	@endif

	<button class="fluid ui button primary" style="margin-bottom: 15px">Lọc</button>
	<a href="{{ route('search') }}" class="fluid ui button">Hủy</a>
</form>

@push('js_footer')
	<script type="text/javascript">
		$(function(){
			$('.filter-sale').checkbox();
			$('.filter-filter').dropdown();
			@if(isset($filter['filter_id']))
				$('.filter-filter').dropdown('set selected', '{{ $filter['filter_id'] }}');
			@endif

			$('.filter-price').dropdown();
			@if(isset($filter['price']))
				$('.filter-price').dropdown('set selected', '{{ $filter['price'] }}');
			@endif

			$('.filter-category').dropdown();
			@if(isset($filter['category_id']))
				$('.filter-category').dropdown('set selected', '{{ $filter['category_id'] }}');
			@endif

			$('.filter-brand').dropdown();
			@if(isset($filter['brand_id']))
				$('.filter-brand').dropdown('set selected', '{{ $filter['brand_id'] }}');
			@endif

			$('.filter-tags').dropdown({
				allowAdditions: true
			});
		});
	</script>
@endpush