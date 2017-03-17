<div class="checker">
	<input type="checkbox" name="{{ $name or '' }}" value="{{ $value or '' }}" class="icheck {{ $params['class'] or '' }}">
</div>

@addCss('css', asset_url('admin', 'global/plugins/icheck/skins/all.css'))
@addJs('js_footer', asset_url('admin', 'global/plugins/icheck/icheck.min.js'))