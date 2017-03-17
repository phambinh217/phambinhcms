<select name="{{ $name }}" class="form-control {{ $class or '' }}" {!! $attributes or '' !!}>
    <option></option>
    @foreach($status as $status_item)
    	<option {{ isset($selected) && $selected == $status_item['slug'] ? 'selected' : '' }} value="{{ $status_item['slug'] }}">{{ $status_item['name'] }}</option>
    @endforeach
</select>