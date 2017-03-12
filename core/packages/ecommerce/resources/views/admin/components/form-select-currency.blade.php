<select name="{{ $name }}" class="form-control {{ $class or '' }}" {!! $attributes or '' !!}>
    <option value="0"></option>
    @foreach($currencies as $currency_item)
    	<option {{ isset($selected) && $selected == $currency_item->id ? 'selected' : '' }} value="{{ $currency_item->id }}">{{ $currency_item->name }} ({{ $currency_item->code }})</option>
    @endforeach
</select>