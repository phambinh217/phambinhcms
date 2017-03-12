@php 
	if (!isset($level)) {
		$level = 0;
		$parent_id = 0;
	}
@endphp

@if($level == 0)
	<select name="{{ $name }}" class="form-control {{ $class or '' }}" {!! $attributes or '' !!}>
		<option value="0"></option>
		@foreach($brands as $brand_item)
			@php $has_child = $brands->where('parent_id', $brand_item->id)->first(); @endphp
			@if($brand_item->parent_id == $parent_id)		
				<option {{ isset($selected) && $selected == $brand_item->id ? 'selected' : '' }} value="{{ $brand_item->id }}">{{ $brand_item->name }}</option>
				@if($has_child)
					@include('Ecommerce::admin.components.form-select-brand', [
						'brands' => $brands,
						'name' => $name,
						'class' => isset($class) ? $class : '',
						'attributes' => isset($attributes) ? $attributes : '',
						'selected' => isset($selected) ? $selected : '',
						'parent_id' => $brand_item->id,
						'level' => $level + 1,
					])
				@endif
			@endif
		@endforeach
	</select>
@else
	@foreach($brands as $brand_item)
		@php $has_child = $brands->where('parent_id', $brand_item->id)->first(); @endphp
		@if($brand_item->parent_id == $parent_id)		
			<option {{ isset($selected) && $selected == $brand_item->id ? 'selected' : '' }} value="{{ $brand_item->id }}">{{ str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $level) . $brand_item->name }}</option>
			@if($has_child)
				@include('Ecommerce::admin.components.form-select-brand', [
					'brands' => $brands,
					'name' => $name,
					'class' => isset($class) ? $class : '',
					'attributes' => isset($attributes) ? $attributes : '',
					'selected' => isset($selected) ? $selected : '',
					'parent_id' => $brand_item->id,
					'level' => $level + 1,
				])
			@endif
		@endif
	@endforeach
@endif