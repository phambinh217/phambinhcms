<input class="form-control input-tags" value="{{ count($tags) ? $tags->implode('name', ',') : '' }}" />
<div class="tags-value">
	@foreach($tags as $tag_item)
    	<input type="hidden" name="{!! $name !!}" value="{{ $tag_item->id }}" />
    @endforeach
</div>

@push('css')
	<link rel="stylesheet" type="text/css" href="{{ asset_url('admin', 'global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset_url('admin', 'global/plugins/typeahead/typeahead.css') }}">
@endpush

@push('js_footer')
	<script type="text/javascript" src="{{ asset_url('admin', 'global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset_url('admin', 'global/plugins/typeahead/handlebars.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset_url('admin', 'global/plugins/typeahead/typeahead.bundle.min.js') }}"></script>
	<script type="text/javascript">
		$(function() {
			var tags = new Bloodhound({
				datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
				queryTokenizer: Bloodhound.tokenizers.whitespace,
				prefetch: {
					cache: false,
					url: '{{ api_url('v1/ecommerce/tag') }}',
					filter: function(list) {
						return $.map(list, function(item) {
							return item;
						});
					}
				}
			});
			tags.initialize();

			$('.input-tags').tagsinput({
				typeaheadjs: {
					name: 'inputtags',
					displayKey: 'name',
					valueKey: 'name',
					source: tags.ttAdapter(),
				}
			});
			
			@if(isset($create) && $create == true)
				$('.input-tags').on('itemAdded', function(e) {
					var tagName = e.item;
					$.ajax({
						url: '{{ api_url('v1/ecommerce/tag/first-or-create') }}',
						type: 'post',
						dataType: 'json',
						data: {
							name: tagName,
							_token: csrfToken(),
						},
						success: function(res) {
							$('.tags-value').append('<input type="hidden" name="{!! $name !!}" value="'+res.id+'" />');
						},
					});
				});
			@endif
		});
	</script>
@endpush