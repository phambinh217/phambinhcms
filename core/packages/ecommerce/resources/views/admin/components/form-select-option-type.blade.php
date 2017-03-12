<select name="{{ $name }}" class="form-control {{ $class or '' }}" {!! $attributes or '' !!}>
	<option></option>
    @foreach($types as $group_name => $type)
        <optgroup label="{{ $group_name }}">
            @foreach($type as $type_item)
                <option {{ isset($selected) && $selected == $type_item['id'] ? 'selected' : '' }} value="{{ $type_item['id'] }}">{{ $type_item['name'] }}</option>
            @endforeach
        </optgroup>
    @endforeach
</select>