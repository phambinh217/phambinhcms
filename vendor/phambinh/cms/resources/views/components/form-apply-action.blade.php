<div class="form-group">
	<select class="form-control multiple-function">
		<option></option>
		@foreach($actions as $action)
			<option data-method="{{ $action['method'] or '' }}" value="{{ $action['action'] }}">{{ $action['name'] }}</option>
		@endforeach
	</select>
</div>
<div class="form-group">
	<button class="btn btn-primary btn-apply full-width-xs">@lang('cms.apply')</button>
</div>