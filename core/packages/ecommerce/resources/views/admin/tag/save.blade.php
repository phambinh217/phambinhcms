@extends('Cms::layouts.default',[
	'active_admin_menu'	=> [ 'ecommerce', ' ecommerce.tag', isset($tag_id) ? ' ecommerce.tag.index' : ' ecommerce.tag.create'],
	'breadcrumbs' 			=> [
		'title'	=> ['Thẻ', isset($tag_id) ? trans('cms.add-new') : trans('cms.edit')],
		'url'	=> [
			route('admin.ecommerce.tag.index')
		],
	],
])

@section('page_title', isset($tag_id) ? 'Chỉnh sửa thẻ' : 'Thêm thẻ mới')

@if(isset($tag_i))
	@section('page_sub_title', $tag->name)
	@section('tool_bar')
		<a href="{{ route('admin.ecommerce.tag.create') }}" class="btn btn-primary">
			<i class="fa fa-plus"></i> <span class="hidden-xs">Thêm thẻ mới</span>
		</a>
	@endsection
@endif

@section('content')
	<form action="{{ isset($tag_id) ? route('admin.ecommerce.tag.update', ['id' => $tag->id])  : route('admin.ecommerce.tag.store') }}" method="post" class="form-horizontal form-bordered form-row-stripped ajax-form">
		@if(isset($tag_id))
			{{ method_field('PUT') }}
		@endif
		{{ csrf_field() }}
		<div class="form-body">
			<div class="form-group">
				<label class="control-label col-sm-3 pull-left">
					Tên thẻ <span class="required">*</span>
				</label>
				<div class="col-sm-7">
					<input value="{{ $tag->name }}" name="tag[name]" type="text" placeholder="" class="form-control">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3 pull-left">
					Slug
				</label>
				<div class="col-sm-7">
					<input value="{{ $tag->slug }}" name="tag[slug]" type="text" placeholder="" class="form-control">
					<label class="checkbox-inline">
						<input type="checkbox" value="true" checked="" id="create-slug">
						Từ tên thẻ
					</label>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3 pull-left">
					Biểu tượng
				</label>
				<div class="col-sm-7">
					<input value="{{ $tag->icon }}" name="tag[icon]" type="text" placeholder="" class="form-control" />
					<span class="help-block"> Sử dụng fontawesome </span>
				</div>
			</div>
			<div class="form-group">
                <label class="control-label col-md-3">
                    trans('cms.meta-title')
                </label>
                <div class="col-md-7">
                    <input type="text" name="tag[meta_title]" class="form-control" value="{{ $tag->meta_title }}" />
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">
                    trans('cms.meta-description')
                </label>
                <div class="col-md-7">
                    <textarea class="form-control" name="tag[meta_description]">{{ $tag->meta_description }}</textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">
                    trans('cms.meta-keyword')
                </label>
                <div class="col-md-7">
                    <input type="text" name="tag[meta_keyword]" class="form-control" value="{{ $tag->meta_keyword }}" />
                </div>
            </div>
			<div class="form-group media-box-group">
                <label class="control-label col-md-3">
                    Thumbnail
                </label>
                <div class="col-sm-9">
					{!! Form::btnMediaBox('tag[thumbnail]', $tag->thumbnail, thumbnail_url($tag->thumbnail, ['width' => '100', 'height' => '100'])) !!}
                </div>
            </div>
		</div>
		<div class="form-actions util-btn-margin-bottom-5">
			<div class="row">
				<div class="col-md-offset-3 col-md-9">
					@if(!isset($tag_id))
						{!! Form::btnSaveNew() !!}
					@else
						{!! Form::btnSaveOut() !!}
					@endif
				</div>
			</div>
		</div>
	</form>
@endsection

@push('css')
	<link href="{{ asset_url('admin', 'global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
	<link href="{{ asset_url('admin', 'global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push('js_footer')
	<script type="text/javascript" src="{{ asset_url('admin', 'global/plugins/jquery-form/jquery.form.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset_url('admin', 'global/plugins/bootstrap-toastr/toastr.min.js') }}"></script>
	<script type="text/javascript">
		$('#create-slug').click(function() {
			if(this.checked) {
				var title = $('input[name="tag[name]"]').val();
				var slug = strSlug(title);
				$('input[name="tag[slug]"]').val(slug);
			}
		});

		$('input[name="tag[name]"]').keyup(function() {
			if ($('#create-slug').is(':checked')) {
				var title = $(this).val();
				var slug = strSlug(title);
				$('input[name="tag[slug]"]').val(slug);	
			}
		});
	</script>
@endpush
