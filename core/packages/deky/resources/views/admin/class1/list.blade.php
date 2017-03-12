@extends('Cms::layouts.default', [
	'active_admin_menu'	=>	['course', 'course.all'],
	'breadcrumbs'		=>	[
		'title'	=>	['Khóa học', 'Danh sách', 'Quản lí học viên'],
		'url'	=>	[
			route('admin.course.index'),
			route('admin.course.index'),
		],
	],
])

@section('page_title', 'Quản lí học viên')
@section('page_sub_title', $course->title)

@section('tool_bar')
	<a href="{{ route('admin.course.class.create', ['id' => $course->id]) }}" class="btn btn-primary full-width-xs">
		<i class="fa fa-plus"></i><span class="hidden-xs"> Thêm học viên mới</span>
	</a>
@endsection

@section('content')
	<div class="row">
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="dashboard-stat blue">
                <div class="visual">
                    <i class="fa fa-comments"></i>
                </div>
                <div class="details">
                    <div class="number">
                    	<?php $total_student = $course->students->count(); ?>
                        <span data-counter="counterup" data-value="{{ $total_student }}">{{ $total_student }}</span>
                    </div>
                    <div class="desc"> Học viên </div>
                </div>
                <a class="more" href="javascript:;"> View more
                    <i class="m-icon-swapright m-icon-white"></i>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="dashboard-stat red">
                <div class="visual">
                    <i class="fa fa-bar-chart-o"></i>
                </div>
                <div class="details">
                    <div class="number">
                    	<?php $total_user_intro = $course->usersIntro->count('user_intro_id'); ?>
                        <span data-counter="counterup" data-value="{{ $total_user_intro }}">{{ $total_user_intro }}</span></div>
                    <div class="desc"> Người giới thiệu </div>
                </div>
                <a class="more" href="javascript:;"> View more
                    <i class="m-icon-swapright m-icon-white"></i>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="dashboard-stat green">
                <div class="visual">
                    <i class="fa fa-shopping-cart"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="0">0</span>
                    </div>
                    <div class="desc"> Doanh số </div>
                </div>
                <a class="more" href="javascript:;"> View more
                    <i class="m-icon-swapright m-icon-white"></i>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            
        </div>
    </div>
    
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
		                            <label class="control-label col-md-3">ID học viên</label>
		                            <div class="col-md-9">
		                            	<input type="text" name="id" placeholder="ID học viên" value="{{ isset($filter['id']) ? $filter['id'] : '' }}" class="form-control" />
		                            </div>
		                        </div>
		                        <div class="form-group">
		                            <label class="control-label col-md-3">Người giới thiệu</label>
		                            <div class="col-md-9">
		                            	<select class="form-control" name="pivot_user_intro_id">
			                            	<option></option>
			                            	@foreach($course->usersIntro as $user_intro_item)
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
		                            	@include('Student::admin.components.form-select-group', [
	                                		'groups' => $student_groups,
	                                		'name' => 'pivot_student_group_id',
	                                		'selected' => isset($filter['pivot_student_group_id']) ? $filter['pivot_student_group_id'] : '0',
	                                	])
		                            </div>
		                        </div>
		                        <div class="form-group">
		                            <label class="control-label col-md-3">Học viên</label>
		                            <div class="col-md-9">
		                            	@include('Student::admin.components.form-select-intro-status', [
					                        'statuses' => Packages\Deky\Student::statusIntroAble(),
					                        'name' => 'is_intro',
					                        'selected' => isset($filter['is_intro']) ? $filter['is_intro'] : null,
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
							{!! \Packages\Deky\Student::linkSort('ID', 'student_id') !!}
						</th>
						<th class="text-center" style="min-width: 350px">
							{!! \Packages\Deky\Student::linkSort('Họ tên', 'first_name') !!}
						</th>
						<th class="text-center" width="130">
							Nhóm
						</th>
						<th style="min-width: 150px">
							{!! \Packages\Deky\Student::linkSort('Ngày đăng ký', 'pivot_created_at') !!}
						</th>
						<th style="min-width: 150px">Giới thiệu</th>
						<th width="150" class="text-center">Thao tác</th>
					</tr>
				</thead>
				<tbody>
					@foreach($course->students as $student_item)
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
												<a href="javascript:;" remote-modal data-name="#popup-show-user" data-url="{{ route('admin.user.popup-show', ['id' => $student_item->id]) }}" class="text-sm"><i>Xem nhanh</i></a>
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
							@can('admin.student.change-group')
								@include('Student::admin.components.form-select-group', [
	                        		'groups' => $student_groups,
	                        		'name' => 'pivot_student_group_id',
	                        		'selected' => $student_item->pivot->student_group_id,
	                        		'class' => 'bs-select',
	                        		'attributes' => 'data-style="btn-primary btn-sm" data-width="100px" change-group-student data-current-group="'.$student_item->pivot->student_group_id.'" data-url="'.route('admin.class.change-group', ['id' => $student_item->pivot->id]).'"',
	                        	])
	                        @endcan
	                        @cannot('admin.student.change-group')
			                	<strong class="text-primary">
			                		{{ $student_groups->where('id', $student_item->pivot->student_group_id)->first()->title }}
			                	</strong>
		                    @endcannot
						</td>
						<td>{{ $student_item->pivot->created_at->diffForHumans() }}</td>
						<td>
							@if($student_item->pivot->user_intro_id)
								{{ $course->usersIntro->where('id', $student_item->pivot->user_intro_id)->first()->full_name }}
							@else
								Tự đăng ký
							@endif
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
		                            <li><a href="{{ route('admin.student.show', ['id' => $student_item->id]) }}"><i class="fa fa-eye"></i> Xem</a></li>
		                            <li role="presentation" class="divider"> </li>
		                            <li><a href="#" remote-modal data-name="#popup-payment" data-url="{{ route('admin.class.popup-payment', ['class' => $student_item->pivot->id]) }}"><i class="fa fa-dollar"></i> Đóng học phí</a></li>
		                            <li role="presentation" class="divider"> </li>
		                            <li><a href="{{ route('admin.class.edit', ['class' => $student_item->pivot->id]) }}"><i class="fa fa-pencil"></i> Chỉnh sửa</a></li>
		                            <li role="presentation" class="divider"> </li>
		                            <li><a data-function="destroy" data-method="delete" href="{{ route('admin.class.destroy', ['class' => $student_item->pivot->id]) }}"><i class="fa fa-trash"></i> Xóa</a></li>
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
	<link href="{{ asset_url('admin', 'global/plugins/bootstrap-select/css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset_url('admin', 'global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
@endpush

@push('js_footer')
	<script type="text/javascript" src="{{ asset_url('admin', 'global/plugins/jquery-form/jquery.form.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset_url('admin', 'global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset_url('admin', 'global/plugins/bootstrap-toastr/toastr.min.js') }}"></script>
	<script type="text/javascript">
		$(function(){
			$('*[change-group-student]').change(function(){
				var group_id = $(this).val();
				var current_group_id = $(this).attr('data-current-group');
				if(group_id != current_group_id) {
					var url = $(this).attr('data-url');
					$.ajax({
						url: url,
						type: 'post',
						dataType: 'json',
						data: {
							group_id: group_id,
							_method: 'PUT',
							_token: '{{ csrf_token() }}',
						},
					});
				}
			});
		});
	</script>
@endpush

