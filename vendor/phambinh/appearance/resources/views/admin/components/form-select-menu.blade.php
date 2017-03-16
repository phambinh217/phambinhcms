<select name="{{ $name }}" class="form-control {{ $class or '' }}" {{ $attributes or '' }}>
    <option></option>
    @foreach($menus as $menu_item)
    	<option {{ isset($selected) && $selected == $menu_item->id ? 'selected' : '' }} value="{{ $menu_item->id }}">{{ $menu_item->name }}</option>
    @endforeach
</select>