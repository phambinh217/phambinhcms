@extends('Cms::layouts.default',[
	'active_admin_menu' 	=> ['setting', 'fb-comment.setting'],
	'breadcrumbs' 			=> [
		'title'	=> [trans('setting.setting'), trans('fb-comment.fb-comment')],
		'url'	=> [route('admin.setting.general')],
	],
])

@section('page_title', trans('fb-comment.setting-fb-comment'))

@section('content')
	{!! Form::ajax([
		'url' => route('admin.fb-comment.setting.update'),
		'class' => 'form-horizontal',
		'method' => 'PUT',
	]) !!}
		<div class="form-body">
			<div class="form-group">
				<label class="control-lalel col-sm-3 pull-left">
					@lang('fb-comment.apply-fb-comment')
				</label>
				<div class="col-sm-9">
					{!! Form::select('fb_comment_apply', [
						'false' => trans('cms.no'),
						'true' => trans('cms.yes'),
					], $fb_comment_apply, ['class' => 'form-control width-auto', 'id' => 'fb-comment-apply']) !!}
				</div>
			</div>
			<div id="fb-comment-setting" {!! $fb_comment_apply == 'true' ? '' : 'style="display: none"' !!}>
				<div class="form-group">
					<label class="control-lalel col-sm-3 pull-left">
						@lang('fb-comment.fb-js-sdk')
					</label>
					<div class="col-sm-7">
						<textarea class="form-control" name="fb_js_sdk" id="" rows="5">{!! $fb_js_sdk !!}</textarea>
					</div>
				</div>
				<div class="form-group">
					<label class="control-lalel col-sm-3 pull-left">
						@lang('fb-comment.fb-comment-perpage')
					</label>
					<div class="col-sm-7">
						<input type="text" name="fb_comment_perpage" class="form-control" value="{{ $fb_comment_perpage }}" />
					</div>
				</div>
			</div>
		</div>
		<div class="form-actions util-btn-margin-bottom-5">
			{!! Form::btnSaveCancel() !!}
		</div>
	{!! Form::close() !!}
@endsection

@push('js_footer')
	<script type="text/javascript">
		$(function(){
			$('#fb-comment-apply').change(function(){
    			if ($(this).val() == 'true') {
    				$('#fb-comment-setting').show();
    			} else {
    				$('#fb-comment-setting').hide();
    			}
    		});
		});
	</script>
@endpush
