@php 
	if (!isset($level)) {
		$level = 0;
		$parent_id = 0;
	}
@endphp

@if($level == 0)
	<select name="{{ $name }}" class="form-control {{ $class or '' }}" {!! $attributes or '' !!}>
		<option value="0"></option>
		@foreach($groups as $group_item)
			@php $has_child = $groups->where('parent_id', $group_item->id)->first(); @endphp
			@if($group_item->parent_id == $parent_id)		
				<option {{ isset($selected) && $selected == $group_item->id ? 'selected' : '' }} value="{{ $group_item->id }}">{{ $group_item->name }}</option>
				@if($has_child)
					@include('Student::admin.components.form-select-group', [
						'groups' => $groups,
						'name' => $name,
						'class' => isset($class) ? $class : '',
						'attributes' => isset($attributes) ? $attributes : '',
						'selected' => isset($selected) ? $selected : '',
						'parent_id' => $group_item->id,
						'level' => $level + 1,
					])
				@endif
			@endif
		@endforeach
	</select>
@else
	@foreach($groups as $group_item)
		@php $has_child = $groups->where('parent_id', $group_item->id)->first(); @endphp
		@if($group_item->parent_id == $parent_id)		
			<option {{ isset($selected) && $selected == $group_item->id ? 'selected' : '' }} value="{{ $group_item->id }}">{{ str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $level) . $group_item->name }}</option>
			@if($has_child)
				@include('Student::admin.components.form-select-group', [
					'groups' => $groups,
					'name' => $name,
					'class' => isset($class) ? $class : '',
					'attributes' => isset($attributes) ? $attributes : '',
					'selected' => isset($selected) ? $selected : '',
					'parent_id' => $group_item->id,
					'level' => $level + 1,
				])
			@endif
		@endif
	@endforeach
@endif