<select name="{{ $name }}" id="select2-button-addons-single-input-group-sm" class="form-control find-course">
     @if(isset($selected) && $selected)
        <option value="{{ $selected }}" selected>{{ Packages\Deky\Course::select('id', 'title')->find($selected)->title }}</option>
    @endif
</select>

@push('css')
	<link rel="stylesheet" type="text/css" href="{{ asset_url('admin', 'global/plugins/select2/css/select2.min.css') }}" />
	<link rel="stylesheet" type="text/css" href="{{ asset_url('admin', 'global/plugins/select2/css/select2-bootstrap.min.css') }}" />
@endpush

@push('js_footer')
	<script type="text/javascript" src="{{ asset_url('admin', 'global/plugins/select2/js/select2.full.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset_url('deky', 'js/form-find-course.js') }}"></script>
	<script type="text/javascript">
		$(function(){
			var user = new findCoruse({
				el: '.find-course',
				url: '{{ api_url('v1/course') }}',
				defaultThumbnail: '{{ setting('thumbnail-default') }}',
				placeholder: 'Tìm kiếm',
			});
		});
	</script>
@endpush