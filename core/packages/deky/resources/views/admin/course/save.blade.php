@extends('Cms::layouts.default',[
	'active_admin_menu' 	=> ['course', isset($course_id) ? 'course.all' : 'course.create'],
	'breadcrumbs' 			=> [
		'title'	=> ['Khóa học', isset($course_id) ? trans('cms.edit') : trans('cms.add-new')],
		'url'	=> [
			route('admin.course.index')
		],
	],
])

@section('page_title', isset($course_id) ? 'Chỉnh sửa khóa học' : 'Thêm khóa học mới')

@if(isset($course_id))
    @section('page_sub_title', $course->title)
    @section('tool_bar')
        <a href="{{ route('admin.course.create') }}" class="btn btn-primary full-width-xs">
            <i class="fa fa-plus"></i> <span class="hidden-xs">Thêm khóa học mới</span>
        </a>
    @endsection
@endif

@section('content')
    <div class="portlet light bordered form-fit">
        <div class="portlet-title with-tab">
            <div class="tab-default">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#course-content" data-toggle="tab" aria-expanded="true"> Nội dung </a>
                    </li>
                    <li class="">
                        <a href="#course-data" data-toggle="tab" aria-expanded="false"> Dữ liệu </a>
                    </li>
                    <li class="">
                        <a href="#course-seo" data-toggle="tab" aria-expanded="false"> SEO </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="portlet-body form">
            {!! Form::ajax(['method' => isset($course_id) ? 'PUT' : 'POST' , 'url' => isset($course_id) ? route('admin.course.update', ['id' => $course->id]) : route('admin.course.store'), 'class' => 'form-horizontal form-bordered form-row-stripped']) !!}
                <div class="form-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="course-content">
                            <div class="form-group">
                                <label class="control-label col-md-2">
                                    Tên khóa học<span class="required">*</span>
                                </label>
                                <div class="col-sm-10">
                                    <div class="row">
                                        <div class="col-sm-6">
                                        <input value="{{ $course->title }}" name="course[title]" type="text" class="form-control" />
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" name="course[slug]" value="{{ $course->slug }}" placeholder="Slug" class="form-control str-slug" value="{{ $course->slug or '' }}" />
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
                                    {!! Form::tinymce('course[content]', $course->content) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2">
                                    Kiến thức mục tiêu<span class="required">*</span>
                                </label>
                                <div class="col-md-10">
                                    <textarea class="form-control" name="course[target]">{{ $course->target }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="course-data">
                            <div class="form-group">
                                <label class="control-label col-md-2">
                                    Danh mục<span class="required">*</span>
                                </label>
                                <div class="col-md-10">
                                    @include('Deky::admin.components.form-checkbox-category', [
                                        'categories' =>  Packages\Deky\Category::get(),
                                        'name' => 'course[category_id][]',
                                        'checked' => $course->categories->pluck('id')->all(),
                                    ])
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2">
                                    Lịch khai giảng<span class="required">*</span>
                                </label>
                                <div class="col-sm-3">
                                    <input type="text" value="{{ isset($course_id) ? changeFormatDate($course->time_open, 'Y-m-d', 'd-m-Y') : '' }}" name="course[time_open]" class="form-control" placeholder="Từ ngày: dd-mm-yyyy">
                                </div>
                                <div class="col-sm-3">
                                    <input type="text" value="{{ isset($course_id) ? changeFormatDate($course->time_finish, 'Y-m-d', 'd-m-Y') : '' }}" name="course[time_finish]" class="form-control" placeholder="Đến ngày: dd-mm-yyyy">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2">
                                    Học phí<span class="required">*</span>
                                </label>
                                <div class="col-md-3">
                                    <input  value="{{ $course->price or '0' }}" name="course[price]" type="text" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2">
                                    Giảng viên<span class="required">*</span>
                                </label>
                                <div class="col-md-3">
                                    @include('Cms::components.form-find-user', [
                                        'name'      => 'course[trainer_id]',
                                        'selected'  => isset($course_id) ? $course->trainer_id : NULL,
                                    ])
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2">
                                    Số bài học<span class="required">*</span>
                                </label>
                                <div class="col-md-3">
                                    <input value="{{ $course->lesson or '0' }}" name="course[lesson]" type="text" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2">
                                    Số bài kiểm tra<span class="required">*</span>
                                </label>
                                <div class="col-md-3">
                                    <input value="{{ $course->test or '0' }}" name="course[test]" type="text" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group media-box-group">
                                <label class="control-label col-md-2">
                                    Thumbnail
                                </label>
                                <div class="col-sm-10">
                                    {!! Form::btnMediaBox('course[thumbnail]', $course->thumbnail, thumbnail_url($course->thumbnail, ['width' => '100', 'height' => '100'])) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2">
                                    Trạng thái <span class="required">*</span>
                                </label>
                                <div class="col-sm-10">
                                    @include('Deky::admin.components.form-select-status', [
                                        'statuses' => $course->statusAble(),
                                        'class' => 'width-auto',
                                        'name' => 'course[status]',
                                        'selected' => isset($course_id) ? ($course->status == 1 ? 'enable' : 'disable') : null,
                                    ])
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="course-seo">
                            <div class="form-group">
                                <label class="control-label col-md-2">
                                    trans('cms.meta-title')
                                </label>
                                <div class="col-md-10">
                                    <input type="text" name="course[meta_title]" class="form-control" value="{{ $course->meta_title }}" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2">
                                    trans('cms.meta-description')
                                </label>
                                <div class="col-md-10">
                                    <textarea class="form-control" name="course[meta_description]">{{ $course->meta_description }}</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2">
                                    trans('cms.meta-keyword')
                                </label>
                                <div class="col-md-10">
                                    <input type="text" name="course[meta_keyword]" class="form-control" value="{{ $course->meta_keyword }}" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-actions util-btn-margin-bottom-5">
                    <div class="row">
                        <div class="col-md-offset-3 col-md-9">
                            @if(!isset($course_id))
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
                    var title = $('input[name="course[title]"]').val();
                    var slug = strSlug(title);
                    $('input[name="course[slug]"]').val(slug);
                }
            });

            $('input[name="course[title]"]').keyup(function() {
                if ($('#create-slug').is(':checked')) {
                    var title = $(this).val();
                    var slug = strSlug(title);
                    $('input[name="course[slug]"]').val(slug); 
                }
            });
        });
    </script>
@endpush
