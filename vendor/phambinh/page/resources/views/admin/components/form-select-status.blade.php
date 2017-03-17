<select name="{{ $name }}" class="form-control {{ $class or '' }}" {!! $attributes or '' !!}>
    <option></option>
    @foreach($statuses as $statuses_item)
    	<option {{ isset($selected) && $selected == $statuses_item['slug'] ? 'selected' : '' }} value="{{ $statuses_item['slug'] }}">{{ $statuses_item['name'] }}</option>
    @endforeach
</select>