@extends('Cms::layouts.default',[
	'active_admin_menu'	=> [ 'ecommerce', ' ecommerce.brand', isset($brand_id) ? ' ecommerce.brand.index' : ' ecommerce.brand.create'],
	'breadcrumbs' 			=> [
		'title'	=> ['Danh mục', isset($brand_id) ? trans('cms.add-new') : trans('cms.edit')],
		'url'	=> [
			route('admin.ecommerce.brand.index')
		],
	],
])

@section('page_title', isset($brand_id) ? 'Chỉnh sửa thương hiệu' : 'Thêm thương hiệu mới')

@if(isset($brand_id))
	@section('page_sub_title', $brand->name)
	@section('tool_bar')
		<a href="{{ route('admin.ecommerce.brand.create') }}" class="btn btn-primary">
			<i class="fa fa-plus"></i> <span class="hidden-xs">Thêm thương hiệu mới</span>
		</a>
	@endsection
@endif

@section('content')
	<form action="{{ isset($brand_id) ? route('admin.ecommerce.brand.update', ['id' => $brand->id])  : route('admin.ecommerce.brand.store') }}" method="post" class="form-horizontal form-bordered form-row-stripped ajax-form">
		@if(isset($brand_id))
			{{ method_field('PUT') }}
		@endif
		{{ csrf_field() }}
		<div class="form-body">
			<div class="form-group">
				<label class="control-label col-sm-3 pull-left">
					Tên thương hiệu <span class="required">*</span>
				</label>
				<div class="col-sm-7">
					<input value="{{ $brand->name }}" name="brand[name]" type="text" placeholder="" class="form-control">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3 pull-left">
					Slug
				</label>
				<div class="col-sm-7">
					<input value="{{ $brand->slug }}" name="brand[slug]" type="text" placeholder="" class="form-control">
					<label class="checkbox-inline">
						<input type="checkbox" value="true" checked="" id="create-slug">
						Từ tên thương hiệu
					</label>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3 pull-left">
					Thương hiệu cha
				</label>
				<div class="col-sm-7">
					@include('Ecommerce::admin.components.form-select-category', [
                		'categories' => $brand->parentAble()->get(),
                		'name' => 'brand[parent_id]',
                		'selected' => isset($brand_id) ? $brand->parent_id : '0',
                	])
                	<span class="help-block"> Để trống nếu bạn muốn thương hiệu này là thương hiệu gốc </span>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3 pull-left">
					Biểu tượng
				</label>
				<div class="col-sm-7">
					<input value="{{ $brand->icon }}" name="brand[icon]" type="text" placeholder="" class="form-control" />
					<span class="help-block"> Sử dụng fontawesome </span>
				</div>
			</div>
			<div class="form-group">
                <label class="control-label col-md-3">
                    trans('cms.meta-title')
                </label>
                <div class="col-md-7">
                    <input type="text" name="brand[meta_title]" class="form-control" value="{{ $brand->meta_title }}" />
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">
                    trans('cms.meta-description')
                </label>
                <div class="col-md-7">
                    <textarea class="form-control" name="brand[meta_description]">{{ $brand->meta_description }}</textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">
                    trans('cms.meta-keyword')
                </label>
                <div class="col-md-7">
                    <input type="text" name="brand[meta_keyword]" class="form-control" value="{{ $brand->meta_keyword }}" />
                </div>
            </div>
			<div class="form-group media-box-group">
                <label class="control-label col-md-3">
                    Thumbnail
                </label>
                <div class="col-sm-9">
                	{!! Form::btnMediaBox('brand[thumbnail]', $brand->thumbnail, thumbnail_url($brand->thumbnail, ['width' => '100', 'height' => '100'])) !!}
                </div>
            </div>
		</div>
		<div class="form-actions util-btn-margin-bottom-5">
			<div class="row">
				<div class="col-md-offset-3 col-md-9">
					@if(!isset($brand_id))
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
				var title = $('input[name="brand[name]"]').val();
				var slug = strSlug(title);
				$('input[name="brand[slug]"]').val(slug);
			}
		});

		$('input[name="brand[name]"]').keyup(function() {
			if ($('#create-slug').is(':checked')) {
				var title = $(this).val();
				var slug = strSlug(title);
				$('input[name="brand[slug]"]').val(slug);	
			}
		});
	</script>
@endpush
