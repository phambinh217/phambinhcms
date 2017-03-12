@php 
	if (isset($params['class'])) {
		if (! str_contains($params['class'], 'ajax-form')) {
			$params['class'] .= ' ajax-form';
		}
	} else {
		$params['class'] = 'ajax-form';
	}
@endphp

{!! Form::open($params) !!}
	
@addCss('css', asset_url('admin', 'global/plugins/bootstrap-toastr/toastr.min.css'))
@addCss('css', asset_url('admin', 'pages/css/profile.min.css'))
@addJs('js_footer', asset_url('admin', 'global/plugins/jquery-form/jquery.form.min.js'))
@addJs('js_footer', asset_url('admin', 'global/plugins/bootstrap-toastr/toastr.min.js'))
@addJs('js_footer', asset_url('admin', 'global/plugins/bootstrap-toastr/toastr.min.js'))