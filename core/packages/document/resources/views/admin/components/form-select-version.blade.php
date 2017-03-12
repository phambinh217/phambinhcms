<select name="{{ $name }}" class="form-control {{ $class or '' }}" {!! $attributes or '' !!}>
	<option value="0"></option>
	@foreach($versions as $version_item)
		<option {{ isset($selected) && $selected == $version_item->id ? 'selected' : '' }} value="{{ $version_item->id }}">{{ $version_item->name }}</option>
	@endforeach
</select>