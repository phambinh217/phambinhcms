@extends('Cms::layouts.default',[
	'active_admin_menu' 	=> ['work','work.my-class'],
	'breadcrumbs' 			=> [
		'title'	=> ['Công việc', 'Lớp học của tôi'],
		'url'	=> [
			route('admin.course.index'),
		],
	],
])

@section('page_title', 'Lớp học của tôi')

@section('tool_bar')
	<a href="{{ route('admin.course.create') }}" class="btn btn-primary full-width-xs">
		<i class="fa fa-plus"></i> <span class="hidden-xs">Thêm khóa học mới</span>
	</a>
@endsection

@section('content')
<div class="table-function-container">
   	<div class="portlet light bordered filter">
	    <div class="portlet-title">
	        <div class="caption">
	            <i class="fa fa-filter"></i> Bộ lọc kết quả
	        </div>
	    </div>
	    <div class="portlet-body form">
	        <form class="form-horizontal form-bordered form-row-stripped">
	            <div class="form-body">
	                <div class="row">
	                    <div class="col-sm-6 md-pr-0">
	                        <div class="form-group">
	                            <label class="control-label col-md-3">ID</label>
	                            <div class="col-md-9">
	                                <input name="id" value="{{ $filter['id'] or '' }}" type="text" placeholder="" class="form-control">
	                            </div>
	                        </div>
	                        <div class="form-group">
	                            <label class="control-label col-md-3">Tên khóa học</label>
	                            <div class="col-md-9">
	                                <input name="title" value="{{ $filter['title'] or '' }}" type="text" placeholder="" class="form-control">
	                            </div>
	                        </div>
	                        <div class="form-group">
	                            <label class="control-label col-md-3">Category</label>
	                            <div class="col-md-9">
	                                <select name="category_id" class="form-control select2_category">
	                                	<?php $category = new Packages\Deky\Category; ?>
	                                    <option value="0">-- Chọn --</option>
	                                	@foreach($category->get() as $category_item)
	                                    	<option {{ isset($filter['category_id']) && $filter['category_id'] == $category_item->id ? 'selected' : NULL }} value="{{ $category_item->id }}">{{ $category_item->name }}</option>
	                                    @endforeach
	                                </select>
	                            </div>
	                        </div>
	                        <div class="form-group">
	                            <label class="control-label col-md-3">Giá</label>
	                            <div class="col-md-9">
	                                <input name="price" value="{{ $filter['price'] or '' }}" type="text" placeholder="" class="form-control">
	                            </div>
	                        </div>
	                    </div>
	                    <div class="col-sm-6 md-pl-0">
	                    	<div class="form-group">
	                            <label class="control-label col-md-3">Ngày khai giảng</label>
	                            <div class="col-md-9">
	                                <input name="time_open" value="{{ $filter['time_open'] or '' }}" type="text" placeholder="" class="form-control">
	                            </div>
	                        </div>
	                        <div class="form-group">
	                            <label class="control-label col-md-3">Ngày kết thúc</label>
	                            <div class="col-md-9">
	                                <input name="time_finish" value="{{ $filter['time_finish'] or '' }}" type="text" placeholder="" class="form-control">
	                            </div>
	                        </div>
	                        <div class="form-group">
	                            <label class="control-label col-md-3">Trạng thái</label>
	                            <div class="col-md-9">
	                            	<select name="status" class="form-control">
		                                @foreach([
		                                	['id' 	=> 'enable',
		                                	'name'	=>	'Đăng'],
		                                	['id' 	=> 'disable',
		                                	'name'	=>	'Ẩn'],
		                                ] as $status_item)
		                                	<option {{ isset($filter['status']) && $filter['status'] == $status_item['id'] ? 'selected' : '' }} value="{{ $status_item['id'] }}">{{ $status_item['name'] }}</option>
		                                @endforeach
	                                </select>
	                            </div>
	                        </div>
	                        <div class="form-group">
	                            <label class="control-label col-md-3">Trạng thái thời gian</label>
	                            <div class="col-md-9">
	                            	<select name="time_status" class="form-control">
	                            		<option value="0"> --Chọn-- </option>
		                                @foreach([
		                                	['id' 	=> 'coming',
		                                	'name'	=>	'Sắp khai giảng'],
		                                	['id' 	=> 'finished',
		                                	'name'	=>	'Kết thúc'],
		                                	['id' 	=> 'learning',
		                                	'name'	=>	'Đang học'],
		                                ] as $time_status_item)
		                                	<option {{ isset($filter['time_status']) && $filter['time_status'] == $time_status_item['id'] ? 'selected' : '' }} value="{{ $time_status_item['id'] }}">{{ $time_status_item['name'] }}</option>
		                                @endforeach
	                                </select>
	                            </div>
	                        </div>
	                    </div>
	                </div>
	            </div>
	            <div class="form-actions util-btn-margin-bottom-5">
	                <div class="row">
	                    <div class="col-md-12 text-right">
	                        <button type="submit" class="btn btn-primary full-width-xs">
	                            <i class="fa fa-filter"></i> Lọc
							</button>
	                        <a href="{{ route('admin.course.index') }}" class="btn default accordion-toggle">
	                            <i class="fa fa-times"></i> Hủy
	                        </a>
	                    </div>
	                </div>
	            </div>
	        </form>
	    </div>
	</div>
    <div class="row table-above">
	    <div class="col-sm-6">
	    	<div class="form-inline mb-10">
		    	@include('Cms::components.form-apply-action', [
		    		'actions' => [
		    			['action' => '', 'name' => ''],
		    			['action' => '', 'name' => ''],
		    			['action' => '', 'name' => ''],
		    		],
		    	])
		    </div>
	    </div>
	    <div class="col-sm-6 text-right">
	    	{!! $courses->appends($filter)->render() !!}
	    </div>
    </div>
    <div class="note note-success">
        <p><i class="fa fa-info"></i> Tổng số {{ $courses->total() }} kết quả</p>
    </div>
    <div class="table-responsive main">
		<table class="master-table table table-striped table-hover table-checkable order-column">
			<thead>
				<tr>
					<th width="50" class="table-checkbox text-center">
						<div class="checker">
									<input type="checkbox" class="icheck check-all">
								</div>
					</th>
					<th width="50" class="text-center">
						{!! $course->linkSort('ID', 'id') !!}
					</th>
					<th class="text-center">
						{!! $course->linkSort('Tên khóa học', 'title') !!}
					</th>
					<th class="text-center">
						{!! $course->linkSort('Ngày khai giảng', 'time_open') !!}
					</th>
					<th class="text-center">
						{!! $course->linkSort('Học phí', 'price') !!}
					</th>
					<th class="text-center">Thao tác</th>
				</tr>
			</thead>
			<tbody>
				@foreach($courses as $course_item)
				<tr class="odd gradeX hover-display-container {{ $course_item->statusHtmlClass() }}">
					<td width="50" class="table-checkbox text-center">
						<div class="checker">
							<input type="checkbox" class="icheck" value="{{ $course_item->id }}">
						</div>
					</td>
					<td class="text-center">
						<strong>{{ $course_item->id }}</strong>
					</td>
					<td>
						<a href="">
							<strong>{{ $course_item->title }}</strong>
						</a>
						@if($course_item->isComing())
							<span class="badge badge-warning"> Sắp khai giảng
	                            <i class="fa fa-share"></i>
	                        </span>
	                    @elseif($course_item->isFinished())
	                    	<span class="badge badge-danger"> Đã khai giảng
	                            <i class="fa fa-share"></i>
	                        </span>
						@else
							<span class="badge badge-success"> Đang học
	                            <i class="fa fa-share"></i>
	                        </span>
	                    @endif
						<br />
						Học viên: {{ $course_item->students()->count() }}
						<span class="hover-display pl-15">
							<a href="{{ route('admin.my-class.show', ['id' => $course_item->id]) }}" class="text-sm"><i>Xem chi tiết</i></a>
						</span>
					</td>
					<td class="text-center">
						<strong>{{ text_time_difference($course_item->time_open, 'Y-m-d', 'd-m-Y') }}</strong>
					</td>
					<td class="text-center">
						{{ $course_item->price }}
					</td>
					<td>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
@endsection

@push('css')
	<link href="{{ asset_url('admin', 'global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
	<link href="{{ asset_url('admin', 'global/plugins/icheck/skins/all.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push('js_footer')
	<script type="text/javascript" src="{{ asset_url('admin', 'global/plugins/bootstrap-toastr/toastr.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset_url('admin', 'global/plugins/icheck/icheck.min.js')}} "></script>
@endpush