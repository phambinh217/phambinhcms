@extends('Cms::layouts.default',[
	'active_admin_menu' 	=> ['work', 'work.course'],
	'breadcrumbs' 			=> [
		'title'	=> ['Công việc', 'Giới thiệu khóa học'],
		'url'	=> [
			route('admin.course.intro'),
			route('admin.course.intro'),
		],
	],
])

@section('page_title', 'Giới thiệu khóa học')

@section('content')
	<div class="note note-info note-bordered">
        <p>Danh sách các khóa học chờ khai giảng</p>
    </div>
	<div class="master-tab">
	    <ul class="nav nav-tabs">
	    	@foreach($categories as $category_item)
		        <li class="{{ $loop->first ? 'active' : '' }}">
		            <a href="#category-{{ $category_item->id }}" data-toggle="tab">
		            	<strong>{{ $category_item->name }}</strong>
		            </a> 
		        </li>
	        @endforeach
	    </ul>
	</div>
    <div class="tab-content">
        @foreach($categories as $category_item)
	        <div class="tab-pane {{ $loop->first ? 'active' : '' }}" id="category-{{ $category_item->id }}">
	             <div class="blog-page blog-content-1">
			        <div class="row">
			            @foreach($course
			            	->select('courses.*')
			            	->addSelect(\DB::raw('count(classes.student_id) as total_student'))
			            	->applyFilter([
				            	'category_id' => $category_item->id,
				            	'time_status' => 'coming',
				            ])
				            ->join('classes', 'courses.id', '=', 'classes.course_id')
				            ->groupBy('courses.id')
			            	->get() as $course_item) 
			            <div class="col-sm-4">
			                <div class="blog-post-sm bordered blog-container mt-element-ribbon p-0">
			                	<div class="ribbon ribbon-right ribbon-round ribbon-color-info ribbon-shadow">
			                		Còn {{ text_time_difference($course_item->time_open) }}
			                	</div>
			                    <div class="blog-img-thumb">
			                        <a href="javascript:;">
			                            <img src="{{ $course_item->thumbnail }}">
			                        </a>
			                    </div>
			                    <div class="blog-post-content">
			                        <h2 class="blog-title blog-post-title">
			                            <a href="{{ route('admin.course.show', ['id' => $course_item->id]) }}">{{ $course_item->title }}</a>
			                        </h2>
			                        <p class="blog-post-desc"> {{ strip_tags($course_item->sub_content) }} </p>
			                        <div class="blog-post-foot">
			                            <div class="blog-post-meta">
			                                <i class="icon-calendar font-blue"></i>
			                                <a href="javascript:;">{{ text_time_difference($course_item->time_open, 'Y-m-d', 'd-m-Y') }}</a>
			                            </div>
			                            <div class="blog-post-meta">
			                                <i class="icon-bubble font-blue"></i>
			                                <a href="javascript:;">{{ $course_item->total_student }} Học viên</a>
			                            </div>
			                            <p class="text-right mb-0">
				                            <a remote-modal href="#" data-url="{{ route('admin.course.popup-show', ['coruse' => $course_item->id]) }}" data-name="#popup-show-course" class="btn btn-primary full-width-xs">
				                            	Giới thiệu
				                            </a>
			                            </p>
			                        </div>
			                    </div>
			                </div>
			            </div>
			            @endforeach
			        </div>
			    </div>
	        </div>
        @endforeach
    </div>
@endsection

@push('css')
	<link href="{{ asset_url('admin', 'pages/css/blog.min.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push('js_footer')
	
@endpush