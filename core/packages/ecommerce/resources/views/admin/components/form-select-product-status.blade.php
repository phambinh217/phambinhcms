<select name="{{ $name }}" class="form-control {{ $class or '' }}" {!! $attributes or '' !!}>
    @foreach($statuses as $status_item)
    	<option {{ isset($selected) && $selected == $status_item['slug'] ? 'selected' : '' }} value="{{ $status_item['slug'] }}">{{ $status_item['name'] }}</option>
    @endforeach
</select>