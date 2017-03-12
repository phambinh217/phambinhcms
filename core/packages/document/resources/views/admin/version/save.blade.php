@extends('Cms::layouts.default',[
	'active_admin_menu' 	=> ['document', 'document.version'],
	'breadcrumbs' 			=> [
		'title'	=> ['Bài viết', 'Phiên bản', isset($version_id) ? trans('cms.add-new') : trans('cms.edit')],
		'url'	=> [
			admin_url('document'),
			admin_url('document/version'),
		],
	],
])

@section('page_title', isset($version_id) ? 'Chỉnh sửa phiên bản' : 'Thêm phiên bản mới')

@if(isset($version_id))
	@section('page_sub_title', $version->title)
	@section('tool_bar')
		<a href="{{ route('admin.document.version.create') }}" class="btn btn-primary">
			<i class="fa fa-plus"></i> <span class="hidden-xs">Thêm phiên bản mới</span>
		</a>
	@endsection
@endif

@section('content')
	<form action="{{ isset($version_id) ? route('admin.document.version.show', ['id' => $version->id])  : admin_url('document/version') }}" method="post" class="form-horizontal form-bordered form-row-stripped ajax-form">
		@if(isset($version_id))
			<input type="hidden" name="_method" value="PUT" />
		@endif
		{{ csrf_field() }}
		<div class="form-body">
			<div class="form-group">
				<label class="control-label col-sm-3 pull-left">
					Tên phiên bản <span class="required">*</span>
				</label>
				<div class="col-sm-7">
					<input value="{{ $version->name }}" name="version[name]" type="text" placeholder="" class="form-control">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3 pull-left">
					Slug
				</label>
				<div class="col-sm-7">
					<input value="{{ $version->slug }}" name="version[slug]" type="text" placeholder="" class="form-control">
					<label class="checkbox-inline">
						<input type="checkbox" value="true" checked="" id="create-slug">
						Từ tên phiên bản
					</label>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3 pull-left">
					Mô tả
				</label>
				<div class="col-sm-7">
					<textarea name="version[description]" class="form-control">{{ $version->description }}</textarea>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3 pull-left">
					Biểu tượng
				</label>
				<div class="col-sm-7">
					<input value="{{ $version->icon }}" name="version[icon]" type="text" placeholder="" class="form-control" />
					<span class="help-block"> Sử dụng fontawesome </span>
				</div>
			</div>
			<div class="form-group">
                <label class="control-label col-md-3">
                    trans('cms.meta-title')
                </label>
                <div class="col-md-7">
                    <input type="text" name="version[meta_title]" class="form-control" value="{{ $version->meta_title }}" />
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">
                    trans('cms.meta-description')
                </label>
                <div class="col-md-7">
                    <textarea class="form-control" name="version[meta_description]">{{ $version->meta_description }}</textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">
                    trans('cms.meta-keyword')
                </label>
                <div class="col-md-7">
                    <input type="text" name="version[meta_keyword]" class="form-control" value="{{ $version->meta_keyword }}" />
                </div>
            </div>
			<div class="form-group media-box-group">
                <label class="control-label col-md-3">
                    Thumbnail
                </label>
                <div class="col-sm-9">
                    <input type="hidden" name="version[thumbnail]" class="hide file-input" value="{{ $version->thumbnail }}" />
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="mt-element-card mt-element-overlay">
                                <div class="mt-card-item">
                                    <div class="mt-card-thumbnail mt-overlay-1 fileinput-new fileinput">
                                        <div class="fileinput-new">
                                            @if(old('version.thumbnail'))
                                                <img src="{{old('version.thumbnail')}}" class="image-preview" />
                                            @else
                                                <img src="{{ $version->thumbnail }}" class="image-preview" />
                                            @endif
                                        </div>
                                        <div class="fileinput-preview fileinput-exists"></div>
                                        <div class="mt-overlay">
                                            <ul class="mt-info">
                                                <li>
                                                    <a class="btn default btn-outline open-file-broswer">
                                                        <i class="fa fa-upload"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="btn default btn-outline">
                                                        <i class="fa fa-times"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
		</div>
		<div class="form-actions util-btn-margin-bottom-5">
			<div class="row">
				<div class="col-md-offset-3 col-md-9">
					@if(! isset($version_id))
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
	<script type="text/javascript" src="{{ asset_url('admin', 'global/plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}"></script>
	<script type="text/javascript">
		$('#create-slug').click(function() {
			if(this.checked) {
				var title = $('input[name="version[name]"]').val();
				var slug = strSlug(title);
				$('input[name="version[slug]"]').val(slug);
			}
		});

		$('input[name="version[name]"]').keyup(function() {
			if ($('#create-slug').is(':checked')) {
				var title = $(this).val();
				var slug = strSlug(title);
				$('input[name="version[slug]"]').val(slug);	
			}
		});
	</script>
@endpush
