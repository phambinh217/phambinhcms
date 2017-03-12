@extends('Cms::layouts.default',[
	'active_admin_menu' 	=> ['work', 'work.my-student'],
	'breadcrumbs' 			=> [
		'title'	=> ['Công việc', 'Học viên của tôi', 'Lượt đăng ký'],
		'url'	=> [
			route('admin.course.index'),
			route('admin.my-student.student'),
		],
	],
])

@section('page_title', 'Lượt đăng ký')

@section('tool_bar')
	<a href="{{ admin_url('work/my-student/registry/create') }}" class="btn btn-primary full-width-xs">
		<i class="fa fa-plus"></i> <span class="hidden-xs">Thêm học viên mới</span>
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
	                            <label class="control-label col-md-3">Học viên</label>
	                            <div class="col-md-9">
	                            	@include('Cms::components.form-find-user', [
	                            		'name' => 'author_id',
	                            		'selected' => isset($filter['id']) ? $filter['id'] : '0',
	                            	])
	                            </div>
	                        </div>
	                        <div class="form-group">
	                            <label class="control-label col-md-3">Nhóm học viên</label>
	                            <div class="col-md-9">
	                            	@include('Student::admin.components.form-select-group', [
	                            		'groups' => Packages\Deky\StudentGroup::get(),
	                            		'name' => 'pivot_student_group_id',
	                            		'selected' => isset($filter['pivot_student_group_id']) ? $filter['pivot_student_group_id'] : '',
	                            	])
	                            </div>
	                        </div>
	                    </div>
	                    <div class="col-sm-6 md-pl-0">
	                    	<div class="form-group">
	                            <label class="control-label col-md-3">Ngày đăng ký</label>
	                            <div class="col-md-9">
	                            	<input type="text" name="pivot_created_at" placeholder="Ví dụ: 21-07-2016" value="{{ isset($filter['pivot_created_at']) ? $filter['pivot_created_at'] : '' }}" class="form-control" />
	                            </div>
	                        </div>
	                        <div class="form-group">
	                            <label class="control-label col-md-3">Khóa học</label>
	                            <div class="col-md-9">
	                            	@include('Deky::admin.components.form-find-course', [
                                		'name' => 'id',
                                		'selected' => isset($filter['course_id']) ? $filter['course_id'] : '0',
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
                        	<a href="{{ admin_url('work/my-student/registry') }}" class="btn btn-gray full-width-xs">
                            	<i class="fa fa-times"></i> Hủy
                        	</a>
	                    </div>
	                </div>
	            </div>
	        </form>
	    </div>
	</div>
	<div class="note note-success">
        <p><i class="fa fa-info"></i> Tổng số {{ $students->total() }} kết quả</p>
    </div>
	<div class="row table-above">
	    <div class="col-sm-6"></div>
	    <div class="col-sm-6 text-right">
	    	{!! $students->appends($filter)->render() !!}
	    </div>
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
					<th class="text-center">
						{!! $student->linkSort('ID', 'student_id') !!}
					</th>
					<th class="text-center" style="min-width: 350px">
						{!! $student->linkSort('Họ tên', 'first_name') !!}
					</th>
					<th class="text-center" width="130">
						Nhóm
					</th>
					<th class="">
						Lớp
					</th>
					<th style="min-width: 150px">
						{!! $student->linkSort('Ngày đăng ký', 'pivot_created_at') !!}
					</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				@foreach($students as $student_item)
				<tr class="odd gradeX hover-display-container">
					<td width="50" class="table-checkbox text-center">
						<div class="checker">
							<input type="checkbox" class="icheck" value="{{ $student_item->id }}">
						</div>
					</td>
					<td class="text-center"><strong>{{ $student_item->id }}</strong></td>
					<td>
						<div class="media">
			                <div class="pull-left">
			                    <img class="img-circle" src="{{ setting('default-avatar') }}" alt="" style="max-width: 70px" />
			                </div>

			                <div class="media-body">
			                    <ul class="info unstyle-list">
			                        <li class="name">
			                        	<a href="{{ route('admin.student.show', ['id' => $student_item->id]) }}"><strong>{{ $student_item->full_name }}</strong></a>
			                        	<span class="hover-display pl-15">
											<a href="#" remote-modal data-name="#popup-show-user" data-url="{{ route('admin.user.popup-show', ['id' => $student_item->id]) }}" class="text-sm"><i>Xem nhanh</i></a>
										</span>
			                        </li>
			                        <li>NS: {{ $student_item->birth or trans('cms.empty') }}</li>
			                        <li>SĐT: {{ $student_item->phone or trans('cms.empty') }}</li>
			                        <li>Email: {{ $student_item->email or trans('cms.empty') }}</li>
			                    </ul>
			                </div>
			            </div>
					</td>
					<td class="text-center">
						<code>{{ $student_item->group_title }}</code>
					</td>
					<td style="min-width: 250px">
						<a href="#">{{ $student_item->course_title }}</a>
					</td>
					<td>{{ $student_item->pivot->created_at }}</td>
					<td>
						<div class="btn-group pull-right" table-function="">
                            <a href="" class="btn btn-circle btn-xs grey-salsa btn-sm dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true" aria-expanded="false"> @lang('cms.action')
                                <span class="fa fa-angle-down"> </span>
                            </a>
                            <ul class="dropdown-menu pull-right">
                    			<li><a href="{{ admin_url('work/my-student/registry/' . $student_item->pivot->id .'/edit') }}"><i class="fa fa-pencil"></i> Chỉnh sửa</a></li>        	
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