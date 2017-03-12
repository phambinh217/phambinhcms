<div class="field">
	<label>
		{{ $option->name }}
		@if($option->isRequired())
			<span class="required">*</span>
		@endif
	</label>
	@php $values = $product->optionValues()->where('product_to_option_value.option_id', $option->id)->get(); @endphp
	@foreach($values as $value_item)
        <div class="inline field">
			<div class="ui checkbox">
				<input type="checkbox" name="{{ $name }}[]" value="{{ $value_item->id }}" class="hidden">
				<label>{{ $value_item->value }} ({{ prefix_number( price_format($value_item->pivot->price), $value_item->pivot->prefix) }})</label>
			</div>
			<label></label>
		</div>
    @endforeach
</div>

@push('js_footer')
	<script type="text/javascript">
		$(function(){
			$('.ui.checkbox').checkbox();
		});
	</script>
@endpush