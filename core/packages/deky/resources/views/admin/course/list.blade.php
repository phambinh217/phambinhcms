@extends('Cms::layouts.default', [
	'active_admin_menu'	=> ['course', 'course.all'],
	'breadcrumbs' 		=> [
		'title'	=>	['Khóa học', 'Danh sách'],
		'url'	=>	[
			route('admin.course.index'),
			route('admin.course.index'),
		],
	],
])

@section('page_title', 'Tất cả khóa học')

@section('tool_bar')
	@can('admin.course.create')
		<a href="{{ route('admin.course.create') }}" class="btn btn-primary full-width-xs">
			<i class="fa fa-plus"></i> <span class="hidden-xs">Thêm khóa học mới</span>
		</a>
	@endif
@endsection

@section('content')
	<div class="table-function-container">
	   	<div class="portlet light bordered filter">
		    <div class="portlet-title">
		        <div class="caption">
		            <i class="fa fa-filter"></i> Bộ lọc kết quả
		        </div>
		        <div class="tools">
		        	<a href="javascript:;" class="collapse" data-original-title="" title=""></a>
		        </div>
		    </div>
		    <div class="portlet-body form">
		        <form class="form-horizontal form-bordered form-row-stripped">
		            <div class="form-body">
		                <div class="row">
		                    <div class="col-sm-6 md-pr-0">
		                    	<div class="form-group">
		                            <label class="control-label col-md-3">Tìm kiếm</label>
		                            <div class="col-md-9">
		                                <input name="_keyword" value="{{ $filter['_keyword'] or '' }}" type="text" placeholder="" class="form-control">
		                            </div>
		                        </div>
		                        <div class="form-group">
		                            <label class="control-label col-md-3">Danh mục</label>
		                            <div class="col-md-9">
	                                	@include('Deky::admin.components.form-select-category', [
	                                		'categories' => \Packages\Deky\Category::all(),
	                                		'name' => 'category_id',
	                                		'selected' => isset($filter['category_id']) ? $filter['category_id'] : '0',
	                                	])
		                            </div>
		                        </div>
		                        <div class="form-group">
		                            <label class="control-label col-md-3">Tác giả</label>
		                            <div class="col-md-9">
		                            	@include('Cms::components.form-find-user', [
		                            		'name' => 'author_id',
		                            		'selected' => isset($filter['author_id']) ? $filter['author_id'] : '0',
		                            	])
		                            </div>
		                        </div>
		                        <div class="form-group">
		                            <label class="control-label col-md-3">Ngày khai giảng</label>
		                            <div class="col-md-9">
		                                <input name="time_open" value="{{ $filter['time_open'] or '' }}" type="text" placeholder="" class="form-control">
		                            </div>
		                        </div>
		                    </div>
		                    <div class="col-sm-6 md-pl-0">
		                    	<div class="form-group">
		                            <label class="control-label col-md-3">Giảng viên</label>
		                            <div class="col-md-9">
		                                @include('Cms::components.form-find-user', [
	                                		'name' => 'author_id',
	                                		'selected' => isset($filter['trainer_id']) ? $filter['trainer_id'] : '0',
	                                	])
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
		                            	@include('Deky::admin.components.form-select-status', [
					                        'statuses' => Packages\Deky\Course::statusAble(),
					                        'name' => 'status',
					                        'selected' => isset($filter['status']) ? $filter['status'] : null,
					                    ])
		                            </div>
		                        </div>
		                        <div class="form-group">
		                            <label class="control-label col-md-3">Trạng thái thời gian</label>
		                            <div class="col-md-9">
		                            	@include('Deky::admin.components.form-select-time-status', [
					                        'statuses' => Packages\Deky\Course::timeStatusAble(),
					                        'name' => 'time_status',
					                        'selected' => isset($filter['time_status']) ? $filter['time_status'] : null,
					                    ])
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
							{!! \Packages\Deky\Course::linkSort('ID', 'id') !!}
						</th>
						<th class="text-center">
							{!! \Packages\Deky\Course::linkSort('Tên khóa học', 'title') !!}
						</th>
						<th class="text-center">
							{!! \Packages\Deky\Course::linkSort('Ngày khai giảng', 'time_open') !!}
						</th>
						<th class="text-center">
							{!! \Packages\Deky\Course::linkSort('Học phí', 'price') !!}
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
							@can('admin.course.class.show')
								<span class="hover-display pl-15">
									<a href="{{ route('admin.course.class.show', ['id' => $course_item->id]) }}" class="text-sm"><i>Quản lí học viên</i></a>
								</span>
							@endcan
							<br />
							Giảng viên: {{ $course_item->trainer->full_name }}
						</td>
						<td class="text-center">
							<strong>{{ text_time_difference($course_item->time_open, 'Y-m-d', 'd-m-Y') }}</strong>
						</td>
						<td class="text-center">
							{{ $course_item->price }}
						</td>

						<td>
							<div class="btn-group pull-right" table-function>
								<a href="" class="btn btn-circle btn-xs grey-salsa btn-sm dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
									<span class="hidden-xs">
										@lang('cms.action')
										<span class="fa fa-angle-down"> </span>
									</span>
									<span class="visible-xs">
										<span class="fa fa-cog"> </span>
									</span>
		                        </a>
		                        <ul class="dropdown-menu pull-right">
		                        	@if(Route::has('course.show'))
		                            	<li><a href="{{ route('course.show', ['slug' => $course_item->slug, 'id' => $course_item->id]) }}"><i class="fa fa-eye"></i> Xem</a></li>
		                            @endif
		                            <li><a href="{{ route('admin.course.class.show', ['id' => $course_item->id]) }}"><i class="fa fa-users"></i> Quản lí học viên</a></li>
	                                <li role="presentation" class="divider"> </li>
	                                
	                                	<li><a href="{{ route('admin.course.edit',['id' => $course_item->id]) }}"><i class="fa fa-pencil"></i> Sửa</a></li>
	                            	
	                            	@if($course_item->isEnable())
	                            			<li><a data-function="disable" data-method="put" href="{{ route('admin.course.disable', ['id' => $course_item->id]) }}"><i class="fa fa-recycle"></i> Xóa tạm</a></li>
	                            	@endif

		                            @if($course_item->isDisable())
		                            		<li><a data-function="enable" data-method="put" href="{{ route('admin.course.enable', ['id' => $course_item->id]) }}"><i class="fa fa-recycle"></i> Khôi phục</a></li>

		                            		<li role="presentation" class="divider"></li>
		                            		<li><a data-function="destroy" data-method="delete" href="{{ route('admin.course.destroy', ['id' => $course_item->id]) }}"><i class="fa fa-times"></i> Xóa</a></li>
	                            	@endif
		                        </ul>
		                    </div>
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