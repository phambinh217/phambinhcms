@extends('Cms::layouts.default',[
	'active_admin_menu'	=> [ 'ecommerce', ' ecommerce.category', isset($category_id) ? ' ecommerce.category.index' : ' ecommerce.category.create'],
	'breadcrumbs' 			=> [
		'title'	=> ['Danh mục', isset($category_id) ? trans('cms.add-new') : trans('cms.edit')],
		'url'	=> [
			route('admin.ecommerce.category.index')
		],
	],
])

@section('page_title', isset($category_id) ? 'Chỉnh sửa danh mục' : 'Thêm danh mục mới')

@if(isset($category_id))
	@section('page_sub_title', $category->name)
	@section('tool_bar')
		<a href="{{ route('admin.ecommerce.category.create') }}" class="btn btn-primary">
			<i class="fa fa-plus"></i> <span class="hidden-xs">Thêm danh mục mới</span>
		</a>
	@endsection
@endif

@section('content')
	<form action="{{ isset($category_id) ? route('admin.ecommerce.category.update', ['id' => $category->id])  : route('admin.ecommerce.category.store') }}" method="post" class="form-horizontal form-bordered form-row-stripped ajax-form">
		@if(isset($category_id))
			{{ method_field('PUT') }}
		@endif
		{{ csrf_field() }}
		<div class="form-body">
			<div class="form-group">
				<label class="control-label col-sm-3 pull-left">
					Tên danh mục <span class="required">*</span>
				</label>
				<div class="col-sm-7">
					<input value="{{ $category->name }}" name="category[name]" type="text" placeholder="" class="form-control">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3 pull-left">
					Slug
				</label>
				<div class="col-sm-7">
					<input value="{{ $category->slug }}" name="category[slug]" type="text" placeholder="" class="form-control">
					<label class="checkbox-inline">
						<input type="checkbox" value="true" checked="" id="create-slug">
						Từ tên danh mục
					</label>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3 pull-left">
					Danh mục cha
				</label>
				<div class="col-sm-7">
					@include('Ecommerce::admin.components.form-select-category', [
                		'categories' => $category->parentAble()->get(),
                		'name' => 'category[parent_id]',
                		'selected' => isset($category_id) ? $category->parent_id : '0',
                	])
                	<span class="help-block"> Để trống nếu bạn muốn danh mục này là danh mục gốc </span>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3 pull-left">
					Biểu tượng
				</label>
				<div class="col-sm-7">
					<input value="{{ $category->icon }}" name="category[icon]" type="text" placeholder="" class="form-control" />
					<span class="help-block"> Sử dụng fontawesome </span>
				</div>
			</div>
			<div class="form-group">
                <label class="control-label col-md-3">
                    trans('cms.meta-title')
                </label>
                <div class="col-md-7">
                    <input type="text" name="category[meta_title]" class="form-control" value="{{ $category->meta_title }}" />
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">
                    trans('cms.meta-description')
                </label>
                <div class="col-md-7">
                    <textarea class="form-control" name="category[meta_description]">{{ $category->meta_description }}</textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">
                    trans('cms.meta-keyword')
                </label>
                <div class="col-md-7">
                    <input type="text" name="category[meta_keyword]" class="form-control" value="{{ $category->meta_keyword }}" />
                </div>
            </div>
			<div class="form-group media-box-group">
                <label class="control-label col-md-3">
                    Thumbnail
                </label>
                <div class="col-sm-9">
                    {!! Form::btnMediaBox('category[thumbnail]', $category->thumbnail, thumbnail_url($category->thumbnail, ['width' => '100', 'height' => '100'])) !!}
                </div>
            </div>
		</div>
		<div class="form-actions util-btn-margin-bottom-5">
			<div class="row">
				<div class="col-md-offset-3 col-md-9">
					@if(!isset($category_id))
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
				var title = $('input[name="category[name]"]').val();
				var slug = strSlug(title);
				$('input[name="category[slug]"]').val(slug);
			}
		});

		$('input[name="category[name]"]').keyup(function() {
			if ($('#create-slug').is(':checked')) {
				var title = $(this).val();
				var slug = strSlug(title);
				$('input[name="category[slug]"]').val(slug);	
			}
		});
	</script>
@endpush
