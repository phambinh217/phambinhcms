@extends('Cms::layouts.default',[
	'active_admin_menu' 	=> ['news', 'news.category'],
	'breadcrumbs' 			=> [
		'title'	=> [trans('news.news'), trans('news.category.category'), isset($category_id) ? trans('cms.add-new') : trans('cms.edit')],
		'url'	=> [
			route('admin.news.index'),
			route('admin.news.category.index'),
		],
	],
])

@section('page_title', isset($category_id) ? trans('news.category.edit-category') : trans('news.category.add-new-category'))

@if(isset($category_id))
	@section('page_sub_title', $category->title)
	@section('tool_bar')
		<a href="{{ route('admin.news.category.create') }}" class="btn btn-primary">
			<i class="fa fa-plus"></i> <span class="hidden-xs">@lang('news.category.add-new-category')</span>
		</a>
	@endsection
@endif

@section('content')
	{!! Form::ajax(['url' => isset($category_id) ? route('admin.news.category.update', ['id' => $category->id])  : route('admin.news.category.store'), 'class' => 'form-horizontal form-bordered form-row-stripped', 'method' => isset($category_id) ? 'PUT' : 'POST']) !!}
		<div class="form-body">
			<div class="form-group">
				<label class="control-label col-sm-3 pull-left">
					@lang('news.category.title') <span class="required">*</span>
				</label>
				<div class="col-sm-7">
					<input value="{{ $category->name }}" name="category[name]" type="text" placeholder="" class="form-control">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3 pull-left">
					@lang('news.category.slug')
				</label>
				<div class="col-sm-7">
					<input value="{{ $category->slug }}" name="category[slug]" type="text" placeholder="" class="form-control">
					<label class="checkbox-inline">
						<input type="checkbox" value="true" checked="" id="create-slug">
						@lang('news.category.from-category-title')
					</label>
				</div>
			</div>
			<div class="form-group">
                <label class="control-label col-md-3">
                    @lang('news.category.category-parent') <span class="required">*</span>
                </label>
                <div class="col-md-7">
                    @include('News::admin.components.form-select-category', [
                        'categories' => $category->parentAble()->get(),
                        'name' => 'category[parent_id]',
                        'selected' => isset($category_id) ? $category->parent_id : '0',
                    ])
                    <span class="help-block"> @lang('news.category.empty-is-root') </span>
                </div>
            </div>
			<div class="form-group">
				<label class="control-label col-sm-3 pull-left">
					@lang('news.category.icon')
				</label>
				<div class="col-sm-7">
					<input value="{{ $category->icon }}" name="category[icon]" type="text" placeholder="" class="form-control" />
					<span class="help-block"> @lang('news.category.use-fa') </span>
				</div>
			</div>
			<div class="form-group">
                <label class="control-label col-md-3">
                    @lang('cms.meta-title')
                </label>
                <div class="col-md-7">
                    <input type="text" name="category[meta_title]" class="form-control" value="{{ $category->meta_title }}" />
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">
                    @lang('cms.meta-description')
                </label>
                <div class="col-md-7">
                    <textarea class="form-control" name="category[meta_description]">{{ $category->meta_description }}</textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">
                    @lang('cms.meta-keyword')
                </label>
                <div class="col-md-7">
                    <input type="text" name="category[meta_keyword]" class="form-control" value="{{ $category->meta_keyword }}" />
                </div>
            </div>
			<div class="form-group media-box-group">
                <label class="control-label col-md-3">
                    @lang('cms.thumbnail')
                </label>
                <div class="col-sm-9">
                    {!! Form::btnMediaBox('category[thumbnail]', $category->thumbnail, thumbnail_url($category->thumbnail, ['width' => '100', 'height' => '100'])) !!}
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
	{!! Form::close() !!}
@endsection

@push('js_footer')
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
