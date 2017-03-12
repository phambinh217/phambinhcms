@extends('Cms::layouts.default',[
	'active_admin_menu'	=> [ 'ecommerce', ' ecommerce.filter', isset($filter_id) ? ' ecommerce.filter.index' : ' ecommerce.filter.create'],
	'breadcrumbs' 			=> [
		'title'	=> ['Danh mục', isset($filter_id) ? trans('cms.add-new') : trans('cms.edit')],
		'url'	=> [
			route('admin.ecommerce.filter.index')
		],
	],
])

@section('page_title', isset($filter_id) ? 'Chỉnh sửa bộ lọc' : 'Thêm bộ lọc mới')

@if(isset($filter_id))
	@section('page_sub_title', $filter->name)
	@section('tool_bar')
		<a href="{{ route('admin.ecommerce.filter.create') }}" class="btn btn-primary">
			<i class="fa fa-plus"></i> <span class="hidden-xs">Thêm bộ lọc mới</span>
		</a>
	@endsection
@endif

@section('content')
	<form action="{{ isset($filter_id) ? route('admin.ecommerce.filter.update', ['id' => $filter->id])  : route('admin.ecommerce.filter.store') }}" method="post" class="form-horizontal form-bordered form-row-stripped ajax-form">
		@if(isset($filter_id))
			{{ method_field('PUT') }}
		@endif
		{{ csrf_field() }}
		<div class="form-body">
			<div class="form-group">
				<label class="control-label col-sm-3 pull-left">
					Tên bộ lọc <span class="required">*</span>
				</label>
				<div class="col-sm-7">
					<input value="{{ $filter->name }}" name="filter[name]" type="text" placeholder="" class="form-control">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3 pull-left">
					Slug
				</label>
				<div class="col-sm-7">
					<input value="{{ $filter->slug }}" name="filter[slug]" type="text" placeholder="" class="form-control">
					<label class="checkbox-inline">
						<input type="checkbox" value="true" checked="" id="create-slug">
						Từ tên bộ lọc
					</label>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3 pull-left">
					Bộ lọc cha
				</label>
				<div class="col-sm-7">
					@include('Ecommerce::admin.components.form-select-filter', [
                		'categories' => $filter->parentAble()->get(),
                		'name' => 'filter[parent_id]',
                		'selected' => isset($filter_id) ? $filter->parent_id : '0',
                	])
                	<span class="help-block"> Để trống nếu bạn muốn bộ lọc này là bộ lọc gốc </span>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3 pull-left">
					Biểu tượng
				</label>
				<div class="col-sm-7">
					<input value="{{ $filter->icon }}" name="filter[icon]" type="text" placeholder="" class="form-control" />
					<span class="help-block"> Sử dụng fontawesome </span>
				</div>
			</div>
			<div class="form-group">
                <label class="control-label col-md-3">
                    trans('cms.meta-title')
                </label>
                <div class="col-md-7">
                    <input type="text" name="filter[meta_title]" class="form-control" value="{{ $filter->meta_title }}" />
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">
                    trans('cms.meta-description')
                </label>
                <div class="col-md-7">
                    <textarea class="form-control" name="filter[meta_description]">{{ $filter->meta_description }}</textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">
                    trans('cms.meta-keyword')
                </label>
                <div class="col-md-7">
                    <input type="text" name="filter[meta_keyword]" class="form-control" value="{{ $filter->meta_keyword }}" />
                </div>
            </div>
			<div class="form-group media-box-group">
                <label class="control-label col-md-3">
                    Thumbnail
                </label>
                <div class="col-sm-9">
                    {!! Form::btnMediaBox('filter[thumbnail]', $filter->thumbnail, thumbnail_url($filter->thumbnail, ['width' => '100', 'height' => '100'])) !!}
                </div>
            </div>
		</div>
		<div class="form-actions util-btn-margin-bottom-5">
			<div class="row">
				<div class="col-md-offset-3 col-md-9">
					@if(!isset($filter_id))
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
				var title = $('input[name="filter[name]"]').val();
				var slug = strSlug(title);
				$('input[name="filter[slug]"]').val(slug);
			}
		});

		$('input[name="filter[name]"]').keyup(function() {
			if ($('#create-slug').is(':checked')) {
				var title = $(this).val();
				var slug = strSlug(title);
				$('input[name="filter[slug]"]').val(slug);	
			}
		});
	</script>
@endpush
