<select name="{{ $name }}" class="form-control {{ $class or '' }}" {{ $attributes or '' }}>
    <option></option>
    @foreach($roles as $role_item)
    	<option {{ isset($selected) && $selected == $role_item->id ? 'selected' : '' }} value="{{ $role_item->id }}">{{ $role_item->name }}</option>
    @endforeach
</select>