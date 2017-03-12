@extends('Cms::layouts.default',[
	'active_admin_menu' 	=> ['document', isset($document_id) ? 'document.all' : 'document.create'],
	'breadcrumbs' 			=> [
		'title'	=> ['Bài viết', isset($document_id) ? trans('cms.edit') : trans('cms.add-new')],
		'url'	=> [
			admin_url('document')
		],
	],
])

@section('page_title', isset($document_id) ? 'Chỉnh sửa bài viết' : 'Thêm bài viết mới')

@if(isset($document_id))
    @section('page_sub_title', $document->title)
    @can('admin.document.create')
        @section('tool_bar')
            <a href="{{ route('admin.document.create') }}" class="btn btn-primary">
                <i class="fa fa-plus"></i> <span class="hidden-xs">Thêm bài viết mới</span>
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
                        <a href="#document-content" data-toggle="tab" aria-expanded="true"> Nội dung </a>
                    </li>
                    <li class="">
                        <a href="#document-data" data-toggle="tab" aria-expanded="false"> Dữ liệu </a>
                    </li>
                    <li class="">
                        <a href="#document-seo" data-toggle="tab" aria-expanded="false"> SEO </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="portlet-body form">
            <form method="post" action="{{ isset($document_id) ? admin_url('document/' . $document->id) : admin_url('document') }}" class="form-horizontal form-bordered form-row-stripped ajax-form">
                @if(isset($document_id))
                    <input type="hidden" name="_method" value="PUT" />
                @endif
                {{ csrf_field() }}
                <div class="form-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="document-content">
                            <div class="form-group">
                                <label class="control-label col-sm-2">Tên tin</label>
                                <div class="col-sm-10">
                                    <div class="row">
                                        <div class="col-sm-6">
                                        <input value="{{ $document->title }}" name="document[title]" type="text" class="form-control" />
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" name="document[slug]" value="{{ $document->slug }}" placeholder="Slug" class="form-control str-slug" value="{{ $document->slug or '' }}" />
                                            <label class="checkbox-inline">
                                                <input type="checkbox" value="true" checked="" id="create-slug">
                                                Từ tên tin
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2">
                                    Nội dung<span class="required">*</span>
                                </label>
                                <div class="col-md-10">
                                    {!! Form::tinymce('document[content]', $document->content) !!}
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="document-data">
                            <div class="form-group">
                                <label class="control-label col-md-2">
                                    Phiên bản<span class="required">*</span>
                                </label>
                                <div class="col-md-10">
                                    @include('Document::admin.components.form-select-version', [
                                        'versions' =>  Packages\Document\Version::get(),
                                        'name' => 'document[version_id]',
                                        'selected' => $document->version_id,
                                        'class' => 'width-auto',
                                    ])
                                </div>
                            </div>
                            <div class="form-group media-box-group">
                                <label class="control-label col-md-2">
                                    Thumbnail
                                </label>
                                <div class="col-sm-10">
                                    {!! Form::btnMediaBox('document[thumbnail]', $document->thumbnail, thumbnail_url($document->thumbnail, ['width' => '100', 'height' => '100'])) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2">
                                    Trạng thái <span class="required">*</span>
                                </label>
                                <div class="col-sm-10">
                                    @include('Document::admin.components.form-select-status', [
                                        'statuses' => $document->statusable()->all(),
                                        'class' => 'width-auto',
                                        'name' => 'document[status]',
                                        'selected' => $document->status_slug,
                                    ])
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="document-seo">
                            <div class="form-group">
                                <label class="control-label col-md-2">
                                    trans('cms.meta-title')
                                </label>
                                <div class="col-md-10">
                                    <input type="text" name="document[meta_title]" class="form-control" value="{{ $document->meta_title }}" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2">
                                    trans('cms.meta-description')
                                </label>
                                <div class="col-md-10">
                                    <textarea class="form-control" name="document[meta_description]">{{ $document->meta_description }}</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2">
                                    trans('cms.meta-keyword')
                                </label>
                                <div class="col-md-10">
                                    <input type="text" name="document[meta_keyword]" class="form-control" value="{{ $document->meta_keyword }}" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-actions util-btn-margin-bottom-5">
                    <div class="row">
                        <div class="col-md-offset-3 col-md-9">
                            @if(!isset($document_id))
                                {!! Form::btnSaveNew() !!}
                            @else
                                {!! Form::btnSaveOut() !!}
                            @endif
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('css')
    <link href="{{ asset_url('admin', 'global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset_url('admin', 'global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push('js_footer')
    <script type="text/javascript" src="{{ asset_url('admin', 'global/plugins/jquery-form/jquery.form.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset_url('admin', 'global/plugins/bootstrap-toastr/toastr.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset_url('admin', 'global/plugins/tinymce/tinymce.min.js')}} "></script>
    <script type="text/javascript">
        $(function(){
            $('#create-slug').click(function() {
                if(this.checked) {
                    var title = $('input[name="document[title]"]').val();
                    var slug = strSlug(title);
                    $('input[name="document[slug]"]').val(slug);
                }
            });

            $('input[name="document[title]"]').keyup(function() {
                if ($('#create-slug').is(':checked')) {
                    var title = $(this).val();
                    var slug = strSlug(title);
                    $('input[name="document[slug]"]').val(slug); 
                }
            });
        });
    </script>
@endpush