@extends('Cms::layouts.default',[
	'active_admin_menu' 	=> ['course', 'course.category'],
	'breadcrumbs' 			=> [
		'title'	=> ['Khóa học', 'Danh mục', isset($category_id) ? trans('cms.add-new') : trans('cms.edit')],
		'url'	=> [
			route('admin.course.index'),
			route('admin.course.category.index'),
		],
	],
])

@section('page_title', isset($category_id) ? 'Chỉnh sửa danh mục' : 'Thêm danh mục mới')

@if(isset($category_id))
	@section('page_sub_title', $category->title)
	@section('tool_bar')
		<a href="{{ route('admin.course.category.create') }}" class="btn btn-primary full-width-xs">
			<i class="fa fa-plus"></i> <span class="hidden-xs">Thêm danh mục mới</span>
		</a>
	@endsection
@endif

@section('content')
	<form action="{{ isset($category_id) ? route('admin.course.category.show', ['id' => $category->id])  : route('admin.course.category.index') }}" method="post" class="form-horizontal form-bordered form-row-stripped ajax-form">
		@if(isset($category_id))
			<input type="hidden" name="_method" value="PUT" />
		@endif
		{{ csrf_field() }}
		<div class="form-body">
			<div class="form-group">
				<label class="control-label col-sm-3 pull-left">
					Tên danh mục <span class="required">*</span>
				</label>
				<div class="col-sm-7">
					<input value="{{ $category->title }}" name="category[title]" type="text" placeholder="" class="form-control">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3 pull-left">
					Slug
				</label>
				<div class="col-sm-7">
					<input value="{{ $category->slug }}" name="category[slug]" type="text" placeholder="" class="form-control">
					<span class="help-block"> Slug dùng để tạo đường dẫn thân thiện </span>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3 pull-left">
					Mô tả
				</label>
				<div class="col-sm-7">
					<textarea name="category[description]" class="form-control">{{ $category->description }}</textarea>
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
                    <input type="hidden" name="category[thumbnail]" class="hide file-input" value="{{ $category->thumbnail }}" />
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="mt-element-card mt-element-overlay">
                                <div class="mt-card-item">
                                    <div class="mt-card-thumbnail mt-overlay-1 fileinput-new fileinput">
                                        <div class="fileinput-new">
                                            @if(old('category.thumbnail'))
                                                <img src="{{ old('category.thumbnail')}}" class="image-preview" />
                                            @else
                                                <img src="{{ $category->thumbnail }}" class="image-preview" />
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
					@if(! isset($category_id))
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
	$(function(){
		pb.ajaxForm();
	});
	</script>
@endpush
