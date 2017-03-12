<select name="{{ $name }}" class="form-control {{ $class or '' }}" {!! $attributes or '' !!}>
    <option value="0"></option>
    @foreach($subtract as $subtract_item)
    	<option {{ isset($selected) && $selected == $subtract_item['slug'] ? 'selected' : '' }} value="{{ $subtract_item['slug'] }}">{{ $subtract_item['name'] }}</option>
    @endforeach
</select>