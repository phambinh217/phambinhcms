<div class="field">
	<label>
		{{ $option->name }}
		@if($option->isRequired())
			<span class="required">*</span>
		@endif
	</label>
	<select name="product[option][{{ $option->id }}]">
		<option></option>
		@php $values = $product->optionValues()->where('product_to_option_value.option_id', $option->id)->get(); @endphp
		@foreach($values as $value_item)
			<option value="{{ $value_item->pivot->value_id }}">{{ $value_item->value }} ({{ prefix_number( price_format($value_item->pivot->price), $value_item->pivot->prefix) }})</option>
		@endforeach
	</select>
</div>
