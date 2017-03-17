@extends('Cms::layouts.default',[
	'active_admin_menu' 	=> ['setting', 'setting.general'],
	'breadcrumbs' 			=> [
		'title'	=> [trans('setting.setting'), trans('setting.general')],
		'url'	=> [route('admin.setting.general')],
	],
])

@section('page_title', trans('setting.general-setting'))

@section('content')
	{!! Form::ajax(['method' => 'PUT', 'url' => route('admin.setting.general.update'), 'class' => 'form-horizontal']) !!}
		<div class="form-body">
			<fieldset>
				<legend>@lang('setting.common-info')</legend>
				<div class="form-group">
					<label class="control-lalel col-sm-3 pull-left">
						@lang('setting.language.language')
					</label>
					<div class="col-sm-3">
						{!! Form::select('language', \Language::mapWithKeys(function ($item) {
							return [$item => $item];
						})->all(), $language, ['class' => 'form-control width-auto', 'placeholder' => ''] )!!}
					</div>
				</div>
				<div class="form-group">
					<label class="control-lalel col-sm-3 pull-left">
						@lang('setting.company.name')
					</label>
					<div class="col-sm-3">
						<input type="text" name="company_name" class="form-control" value="{{ $company_name }}" />
					</div>
				</div>
				<div class="form-group">
					<label class="control-lalel col-sm-3 pull-left">
						@lang('setting.company.phone-number')
					</label>
					<div class="col-sm-3">
						<input type="text" name="company_phone" class="form-control" value="{{ $company_phone }}" />
					</div>
				</div>
				<div class="form-group">
					<label class="control-lalel col-sm-3 pull-left">
						@lang('setting.company.email')
					</label>
					<div class="col-sm-3">
						<input type="text" name="company_email" class="form-control" value="{{ $company_email }}" />
					</div>
				</div>
				<div class="form-group">
					<label class="control-lalel col-sm-3 pull-left">
						@lang('setting.company.address')
					</label>
					<div class="col-sm-3">
						<textarea name="company_address" class="form-control" >{{ $company_address }}</textarea>
					</div>
				</div>
				<div class="form-group media-box-group">
					<label class="control-lalel col-sm-3 pull-left">
						@lang('setting.company.logo')
					</label>
					<div class="col-sm-9">
						{!! Form::btnMediaBox('logo', $logo, $logo) !!}
					</div>
				</div>
			</fieldset>
			<fieldset>
				<legend>@lang('setting.seo-setting')</legend>
				<div class="form-group">
					<label class="control-lalel col-sm-3 pull-left">
						@lang('setting.seo.home-title')
					</label>
					<div class="col-sm-3">
						<input type="text" name="home_title" class="form-control" value="{{ $home_title }}" />
					</div>
				</div>
				<div class="form-group">
					<label class="control-lalel col-sm-3 pull-left">
						@lang('setting.seo.home-keyword')
					</label>
					<div class="col-sm-3">
						<input type="text" name="home_keyword" class="form-control" value="{{ $home_keyword }}" />
					</div>
				</div>
				<div class="form-group">
					<label class="control-lalel col-sm-3 pull-left">
						@lang('setting.seo.home-description')
					</label>
					<div class="col-sm-3">
						<textarea name="home_description" class="form-control">{{ $home_description }}</textarea>
					</div>
				</div>
			</fieldset>
			<fieldset>
				<legend>@lang('setting.image-setting')</legend>
				<div class="form-group media-box-group">
					<label class="control-lalel col-sm-3 pull-left">
						@lang('setting.image.default-thumnail')
					</label>
					<div class="col-sm-9">
						{!! Form::btnMediaBox('default_thumbnail', $default_thumbnail, $default_thumbnail) !!}
					</div>
				</div>
				<div class="form-group media-box-group">
					<label class="control-lalel col-sm-3 pull-left">
						@lang('setting.image.default-avatar')
					</label>
					<div class="col-sm-9">
						{!! Form::btnMediaBox('default_avatar', $default_avatar, $default_avatar) !!}
					</div>
				</div>
			</fieldset>
		</div>
		<div class="form-actions util-btn-margin-bottom-5">
			{!! Form::btnSaveCancel() !!}
		</div>
	{!! Form::close() !!}
@endsection

@push('js_footer')
	<script type="text/javascript">
		$(function(){
			$('#confirm-order').change(function(){
    			if ($(this).val() == 'true') {
    				$('#order-status-not-confirm').show();
    			} else {
    				$('#order-status-not-confirm').hide();
    			}
    		});

			$('#order-notify-email').change(function(){
    			if ($(this).val() == 'true') {
    				$('#order-notify-email-user-role').show();
    			} else {
    				$('#order-notify-email-user-role').hide();
    			}
    		});
		});
	</script>
@endpush
