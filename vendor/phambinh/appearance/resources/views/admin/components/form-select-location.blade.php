<select name="{{ $name }}" class="form-control {{ $class or '' }}" {{ $attributes or '' }}>
    <option></option>
    @foreach($locations as $location_item)
    	<option {{ isset($selected) && $selected == $location_item['id'] ? 'selected' : '' }} value="{{ $location_item['id'] }}">{{ $location_item['name'] }}</option>
    @endforeach
</select>