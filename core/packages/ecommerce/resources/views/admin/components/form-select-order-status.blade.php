<select name="{{ $name }}" class="form-control {{ $class or '' }}" {!! $attributes or '' !!}>
	<option></option>
    @foreach($statuses as $status_item)
    	<option {{ isset($selected) && $selected == $status_item->id ? 'selected' : '' }} value="{{ $status_item->id }}">{{ $status_item->name }}</option>
    @endforeach
</select>