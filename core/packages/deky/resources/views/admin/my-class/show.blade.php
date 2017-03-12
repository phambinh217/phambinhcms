@extends('Cms::layouts.default',[
	'active_admin_menu' 	=> ['work', 'work.my-class'],
	'breadcrumbs' 			=> [
		'title'	=> ['Công việc', 'Khóa học của tôi', 'Chi chiết khóa học'],
		'url'	=> [],
	],
])

@section('page_title', $course->title)

@section('tool_bar')
	<a href="{{ route('admin.course.class.create', ['id' => $course->id]) }}" class="btn btn-primary full-width-xs">
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
	                            <label class="control-label col-md-3">ID học viên</label>
	                            <div class="col-md-9">
	                            	<input type="text" name="id" placeholder="ID học viên" value="{{ isset($filter['id']) ? $filter['id'] : '' }}" class="form-control" />
	                            </div>
	                        </div>
	                        <div class="form-group">
	                            <label class="control-label col-md-3">ID người giới thiệu</label>
	                            <div class="col-md-9">
	                            	<?php $users_intro = $course->usersIntro()->distinct()->get(); ?>
	                            	<select class="form-control" name="pivot_user_intro_id">
		                            	<option value="0">-- Chọn --</option>
		                            	@foreach($users_intro as $user_intro_item)
		                            		<option {{ isset($filter['pivot_user_intro_id']) && $filter['pivot_user_intro_id'] == $user_intro_item->id ? 'selected' : '' }} value="{{ $user_intro_item->id }}">{{ $user_intro_item->full_name }}</option>
		                            	@endforeach
	                            	</select>
	                            </div>
	                        </div>
	                        <div class="form-group">
	                            <label class="control-label col-md-3">Họ và tên</label>
	                            <div class="col-md-9">
	                            	<div class="row">
	                            		<div class="col-sm-6">
	                                		<input type="text" name="last_name" placeholder="Họ và tên đệm" value="{{ isset($filter['last_name']) ? $filter['last_name'] : '' }}" class="form-control" />
	                                	</div>
	                                	<div class="col-sm-6">
	                                		<input type="text" name="first_name" placeholder="Tên" value="{{ isset($filter['first_name']) ? $filter['first_name'] : '' }}" class="form-control" />
	                                	</div>
	                                </div>
	                            </div>
	                        </div>
	                        <div class="form-group">
	                            <label class="control-label col-md-3">Email</label>
	                            <div class="col-md-9">
	                                <input type="text" name="email" placeholder="Email" value="{{ isset($filter['email']) ? $filter['email'] : '' }}" class="form-control" />
	                            </div>
	                        </div>
	                    </div>
	                    <div class="col-sm-6 md-pl-0">
	                    	<div class="form-group">
	                            <label class="control-label col-md-3">Số điện thoại</label>
	                            <div class="col-md-9">
	                                <input type="text" name="phone" placeholder="Số điện thoại" value="{{ isset($filter['phone']) ? $filter['phone'] : '' }}" class="form-control" />
	                            </div>
	                        </div>
	                    	<div class="form-group">
	                            <label class="control-label col-md-3">Ngày đăng ký</label>
	                            <div class="col-md-9">
	                            	<input type="text" name="pivot_created_at" placeholder="Ví dụ: 21-07-2016" value="{{ isset($filter['pivot_created_at']) ? $filter['pivot_created_at'] : '' }}" class="form-control" />
	                            </div>
	                        </div>
	                    	<div class="form-group">
	                            <label class="control-label col-md-3">Nhóm học viên</label>
	                            <div class="col-md-9">
	                            	<?php $student_group = new Packages\Deky\StudentGroup() ?>
	                            	<?php $student_groups = $student_group->select('id', 'title')->get(); ?>
	                            	<select name="pivot_student_group_id" class="form-control">
	                            		<option value="0">-- Chọn --</option>
	                            		@foreach($student_groups as $student_group_item)
	                            			<option {{ isset($filter['pivot_student_group_id']) && $student_group_item->id == $filter['pivot_student_group_id'] ? 'selected' : '' }} value="{{ $student_group_item->id }}">{{ $student_group_item->title }}</option>
	                            		@endforeach
	                            	</select>
	                            </div>
	                        </div>
	                        <div class="form-group">
	                            <label class="control-label col-md-3">Học viên</label>
	                            <div class="col-md-9">
	                            	<select name="is_intro" class="form-control">
	                            		<option value="0">-- Chọn --</option>
	                            		@foreach([
	                            			['id' => 'be-intro',
	                            			'name' => 'Được giới thiệu bởi ai đó'],
	                            			['id' => 'free',
	                            			'name' => 'Tự đăng ký'],
	                            		] as $student_status_item)
	                            			<option {{ isset($filter['is_intro']) && $filter['is_intro'] == $student_status_item['id'] ? 'selected' : '' }} value="{{ $student_status_item['id'] }}">{{ $student_status_item['name'] }}</option>
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
                        	<a href="{{ route('admin.course.class.show', ['id' => $course->id]) }}" class="btn btn-gray full-width-xs">
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
	    	{!! $students->setPath('student')->appends($filter)->render() !!}
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
					<th style="min-width: 150px">
						{!! $student->linkSort('Ngày đăng ký', 'pivot_created_at') !!}
					</th>
					<th width="150" class="text-center">Thao tác</th>
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
											<a href="{{ '' }}" class="text-sm"><i>Xem nhanh</i></a>
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
						<strong>
							{{ $student_group->select('title')->find($student_item->pivot->student_group_id)->title }}
						</strong>
					</td>
					<td>{{ $student_item->pivot->created_at }}</td>
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