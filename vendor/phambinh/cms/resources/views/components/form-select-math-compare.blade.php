<select name="{!! $name !!}" class="form-control">
	<option value="">@lang('cms.equal')</option>
	<option value="less_equal:">@lang('cms.less-equal')</option>
	<option value="greater_equal:">@lang('cms.greater-equal')</option>
	<option value="less:">@lang('cms.less')</option>
	<option value="greater:">@lang('cms.greater')</option>
</select>

@push('js_footer')
	<script type="text/javascript">
		$(function(){
			$('select[name="{!! $name !!}"]').on('change', function(){
				var compare = $(this).val();
				$('{!! $target !!}').attr('value', compare);
			});
		});
	</script>
@endpush