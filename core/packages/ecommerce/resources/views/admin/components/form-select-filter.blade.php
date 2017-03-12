<select name="{{ $name }}" class="form-control {{ $class or '' }}" {!! $attributes or '' !!}>
	<option value="0"></option>
	@foreach($filters as $filter_item)
		<option {{ isset($selected) && $selected == $filter_item->id ? 'selected' : '' }} value="{{ $filter_item->id }}">{{ $filter_item->name }}</option>
	@endforeach
</select>