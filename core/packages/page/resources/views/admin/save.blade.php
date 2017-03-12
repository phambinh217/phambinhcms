@extends('Cms::layouts.default',[
	'active_admin_menu' 	=> ['page', isset($page_id) ? 'page.index' : 'page.create'],
	'breadcrumbs' 			=> [
		'title'	=> [trans('page.page'), isset($page_id) ? trans('cms.edit') : trans('cms.add-new')],
		'url'	=> [
			route('admin.page.index')
		],
	],
])

@section('page_title', isset($page_id) ? trans('page.edit-page') : trans('add-new-page'))

@if(isset($page_id))
    @section('page_sub_title', $page->title)
    @can('admin.page.create')
        @section('tool_bar')
            <a href="{{ route('admin.page.create') }}" class="btn btn-primary">
                <i class="fa fa-plus"></i> <span class="hidden-xs">@lang('add-new-page')</span>
            </a>
        @endsection
    @endcan
@endif

@section('content')
    <div class="portlet light bordered form-fit">
        <div class="portlet-title with-tab">
            <div class="tab-default">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#page-content" data-toggle="tab" aria-expanded="true"> @lang('page.content') </a>
                    </li>
                    <li class="">
                        <a href="#page-data" data-toggle="tab" aria-expanded="false"> @lang('data') </a>
                    </li>
                    <li class="">
                        <a href="#page-seo" data-toggle="tab" aria-expanded="false"> @lang('seo') </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="portlet-body form">
            <form method="post" action="{{ isset($page_id) ? admin_url('page/' . $page->id) : route('admin.page.index') }}" class="form-horizontal form-bordered form-row-stripped ajax-form">
            {!! Form::ajax([
                'url' => isset($page_id) ? route('admin.page.update', ['id' => $page_id]) : route('admin.page.store'),
                'method' => isset($page_id) ? 'PUT' : 'POST',
            ]) !!}
                <div class="form-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="page-content">
                            <div class="form-group">
                                <label class="control-label col-sm-2">@lang('page.title')</label>
                                <div class="col-sm-10">
                                    <div class="row">
                                        <div class="col-sm-6">
                                        <input value="{{ $page->title }}" name="page[title]" type="text" class="form-control" />
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" name="page[slug]" value="{{ $page->slug }}" placeholder="Slug" class="form-control str-slug" value="{{ $page->slug or '' }}" />
                                            <label class="checkbox-inline">
                                                <input type="checkbox" value="true" checked="" id="create-slug">
                                                @lang('page.from-page-title')
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2">
                                    @lang('page.content') <span class="required">*</span>
                                </label>
                                <div class="col-md-10">
                                    {!! Form::tinymce('page[content]', $page->content) !!}
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="page-data">
                            <div class="form-group media-box-group">
                                <label class="control-label col-md-2">
                                    @lang('cms.thumbnail')
                                </label>
                                <div class="col-sm-10">
                                    {!! Form::btnMediaBox('page[thumbnail]', $page->thumbnail, thumbnail_url($page->thumbnail, ['width' => '100', 'height' => '100'])) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2">
                                    @lang('page.status') <span class="required">*</span>
                                </label>
                                <div class="col-sm-10">
                                    {!! Form::select('page[status]', \Packages\Page\Page::statusable()->mapWithKeys(function ($item) {
                                        return [$item['slug'] => $item['name']];
                                    })->all(), $page->status_slug, ['class' => 'form-control width-auto', 'placeholder' => '']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="page-seo">
                            <div class="form-group">
                                <label class="control-label col-md-2">
                                    @lang('cms.meta-title')
                                </label>
                                <div class="col-md-10">
                                    <input type="text" name="page[meta_title]" class="form-control" value="{{ $page->meta_title }}" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2">
                                    @lang('cms.meta-description')
                                </label>
                                <div class="col-md-10">
                                    <textarea class="form-control" name="page[meta_description]">{{ $page->meta_description }}</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2">
                                    @lang('cms.meta-keyword')
                                </label>
                                <div class="col-md-10">
                                    <input type="text" name="page[meta_keyword]" class="form-control" value="{{ $page->meta_keyword }}" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-actions util-btn-margin-bottom-5">
                    <div class="row">
                        <div class="col-md-offset-3 col-md-9">
                            @if(!isset($page_id))
                                {!! Form::btnSaveNew() !!}
                            @else
                                {!! Form::btnSaveOut() !!}
                            @endif
                        </div>
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection

@push('js_footer')
    <script type="text/javascript">
        $(function(){
            $('#create-slug').click(function() {
                if(this.checked) {
                    var title = $('input[name="page[title]"]').val();
                    var slug = strSlug(title);
                    $('input[name="page[slug]"]').val(slug);
                }
            });

            $('input[name="page[title]"]').keyup(function() {
                if ($('#create-slug').is(':checked')) {
                    var title = $(this).val();
                    var slug = strSlug(title);
                    $('input[name="page[slug]"]').val(slug); 
                }
            });
        });
    </script>
@endpush