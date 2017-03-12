<div class="field">
	<label>
		{{ $option->name }}
		@if($option->isRequired())
			<span class="required">*</span>
		@endif
	</label>
	<input type="file" name="{{ $name }}" />
</div>