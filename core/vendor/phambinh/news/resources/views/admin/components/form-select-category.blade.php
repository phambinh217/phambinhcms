@php 
	if (!isset($level)) {
		$level = 0;
		$parent_id = 0;
	}
@endphp

@if($level == 0)
	<select name="{{ $name }}" class="form-control {{ $class or '' }}" {!! $attributes or '' !!}>
		<option value="0"></option>
		@foreach($categories as $category_item)
			@php $has_child = $categories->where('parent_id', $category_item->id)->first(); @endphp
			@if($category_item->parent_id == $parent_id)		
				<option {{ isset($selected) && $selected == $category_item->id ? 'selected' : '' }} value="{{ $category_item->id }}">{{ $category_item->name }}</option>
				@if($has_child)
					@include('News::admin.components.form-select-category', [
						'categories' => $categories,
						'name' => $name,
						'class' => isset($class) ? $class : '',
						'attributes' => isset($attributes) ? $attributes : '',
						'selected' => isset($selected) ? $selected : '',
						'parent_id' => $category_item->id,
						'level' => $level + 1,
					])
				@endif
			@endif
		@endforeach
	</select>
@else
	@foreach($categories as $category_item)
		@php $has_child = $categories->where('parent_id', $category_item->id)->first(); @endphp
		@if($category_item->parent_id == $parent_id)		
			<option {{ isset($selected) && $selected == $category_item->id ? 'selected' : '' }} value="{{ $category_item->id }}">{{ str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $level) . $category_item->name }}</option>
			@if($has_child)
				@include('News::admin.components.form-select-category', [
					'categories' => $categories,
					'name' => $name,
					'class' => isset($class) ? $class : '',
					'attributes' => isset($attributes) ? $attributes : '',
					'selected' => isset($selected) ? $selected : '',
					'parent_id' => $category_item->id,
					'level' => $level + 1,
				])
			@endif
		@endif
	@endforeach
@endif