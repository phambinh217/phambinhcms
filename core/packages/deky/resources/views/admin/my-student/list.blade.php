@extends('Cms::layouts.default',[
	'active_admin_menu' 	=> ['work', 'work.my-student'],
	'breadcrumbs' 			=> [
		'title'	=> ['Công việc', 'Học viên của tôi'],
		'url'	=> [
			admin_url('class'),
		],
	],
])

@section('page_title', 'Học viên của tôi')

@section('tool_bar')
	<a href="{{ admin_url('work/my-student/registry/create') }}" class="btn btn-primary full-width-xs">
		<i class="fa fa-plus"></i> <span class="hidden-xs">Thêm học viên mới</span>
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
                        <span data-counter="counterup" data-value="{{ $registries->count() }}">{{ $registries->count() }}</span>
                    </div>
                    <div class="desc"> Lượt đăng ký </div>
                </div>
                <a class="more" href="{{ admin_url('work/my-student/registry') }}"> Xem chi tiết
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
                        <span data-counter="counterup" data-value="{{ $students->count() }}">{{ $students->count() }}</span></div>
                    <div class="desc"> Học viên </div>
                </div>
                <a class="more" href="{{ admin_url('work/my-student/student') }}"> Xem chi tiết
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
                        <span data-counter="counterup" data-value="{{ $courses->count() }}">{{ $courses->count() }}</span>
                    </div>
                    <div class="desc"> Lớp học có học viên </div>
                </div>
                <a class="more" href="{{ admin_url('work/my-student/course') }}"> Xem chi tiết
                    <i class="m-icon-swapright m-icon-white"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="portlet light bordered">
	    <div class="portlet-title tabbable-line">
	        <div class="caption">
	            <i class="icon-globe font-green-sharp"></i>
	            <span class="caption-subject font-green-sharp bold uppercase"> Lượt đăng ký mới nhất</span>
	        </div>
	        <div class="actions">
	            <a href="{{ admin_url('work/my-student/registry') }}" class="btn btn-circle green btn-sm">
	                <i class="fa fa-list"></i> Xem hết
	            </a>
	        </div>
	    </div>
	    <div class="portlet-body">
	        <div class="scroller" style="height: 339px;" data-always-visible="1" data-rail-visible="0">
	            <table class="table table-striped table-hover table-checkable order-column">
					<thead>
						<tr>
							<th width="50" class="table-checkbox text-center">
								<div class="checker">
									<span>
										<input type="checkbox" class="group-checkable">
									</span>
								</div>
							</th>
							<th class="text-center">STT</th>
							<th class="text-center">ID</th>
							<th>Họ và tên</th>
							<th>Nhóm</th>
							<th>Lớp</th>
							<th>Ngày đăng ký</th>
						</tr>
					</thead>
					@foreach($registries as $register_item)
		            	<?php $student_item = $register_item->student; ?>
						<tr class="pb-class-item hover-display-container">
							<th width="50" class="table-checkbox text-center">
								<div class="checker">
									<span>
										<input type="checkbox" class="group-checkable">
									</span>
								</div>
							</th>
							<td class="text-center"><strong>{{ $loop->index + 1 }}</strong></td>
							<td class="text-center"><strong>{{ $student_item->id }}</strong></td>
		    				<td>
		    					<div class="media">
					                <div class="pull-left">
					                    <img class="img-circle" src="{{ thumbnail_url($student_item->avatar, ['width' => '70', 'height' => '70']) }}" alt="" style="max-width: 70px" />
					                </div>

					                <div class="media-body">
					                    <ul class="info unstyle-list">
					                        <li class="name">
					                        	<a href="{{ route('admin.student.show', ['id' => $student_item->id]) }}"><strong>{{ $student_item->full_name }}</strong></a>
					                        </li>
					                        <li>NS: {{ $student_item->birth or trans('cms.empty') }}</li>
					                        <li>SĐT: {{ $student_item->phone or trans('cms.empty') }}</li>
					                        <li>Email: {{ $student_item->email or trans('cms.empty') }}</li>
					                    </ul>
					                </div>
					            </div>
		    				</td>
		    				<td style="min-width: 100px">
								<code>{{ $register_item->group->title }}</code>
							</td>
		    				<td style="min-width: 250px">
								<a href="{{ route('admin.course.class.show', ['id' => $register_item->id]) }}">{{ $register_item->course->title }}</a>
							</td>
		    				<td style="min-width: 200px">{{ text_time_difference($register_item->created_at) }}</td>
						</tr>
		            @endforeach
				</table>
	        </div>
	    </div>
	</div>

	<div class="portlet light bordered">
	    <div class="portlet-title tabbable-line">
	        <div class="caption">
	            <i class="fa fa-users font-green-sharp"></i>
	            <span class="caption-subject font-green-sharp bold uppercase">Học viên mới nhất</span>
	        </div>
	        <div class="actions">
	            <a href="{{ admin_url('work/my-student/student') }}" class="btn btn-circle green btn-sm">
	                <i class="fa fa-list"></i> Xem hết
	            </a>
	        </div>
	    </div>
	    <div class="portlet-body">
	        <div class="scroller" style="height: 339px;" data-always-visible="1" data-rail-visible="0">
	            <table class="table table-striped table-hover table-checkable order-column">
					<thead>
						<tr>
							<th width="50" class="table-checkbox text-center">
								<div class="checker">
									<span>
										<input type="checkbox" class="group-checkable">
									</span>
								</div>
							</th>
							<th class="text-center">STT</th>
							<th class="text-center">ID</th>
							<th>Họ và tên</th>
							<th style="min-width: 100px" class="text-center">Số lớp học</th>
							<th>Ngày đăng ký</th>
						</tr>
					</thead>
					@foreach($students as $student_item)
						<tr class="pb-class-item hover-display-container">
							<th width="50" class="table-checkbox text-center">
								<div class="checker">
									<span>
										<input type="checkbox" class="group-checkable">
									</span>
								</div>
							</th>
							<td class="text-center"><strong>{{ $loop->index + 1 }}</strong></td>
							<td class="text-center"><strong>{{ $student_item->id }}</strong></td>
		    				<td>
		    					<div class="media">
					                <div class="pull-left">
					                    <img class="img-circle" src="{{ thumbnail_url($student_item->avatar, ['width' => '70', 'height' => '70']) }}" alt="" style="max-width: 70px" />
					                </div>

					                <div class="media-body">
					                    <ul class="info unstyle-list">
					                        <li class="name">
					                        	<a href="{{ route('admin.student.show', ['id' => $student_item->id]) }}"><strong>{{ $student_item->full_name }}</strong></a>
					                        </li>
					                        <li>NS: {{ $student_item->birth or trans('cms.empty') }}</li>
					                        <li>SĐT: {{ $student_item->phone or trans('cms.empty') }}</li>
					                        <li>Email: {{ $student_item->email or trans('cms.empty') }}</li>
					                    </ul>
					                </div>
					            </div>
		    				</td>
		    				<td style="min-width: 100px" class="text-center">
								<strong>{{ $student_item->total_class }}</strong>
							</td>
		    				<td style="min-width: 200px">{{ text_time_difference($student_item->created_at) }}</td>
						</tr>
		            @endforeach
				</table>
	        </div>
	    </div>
	</div>

	<div class="portlet light bordered">
	    <div class="portlet-title tabbable-line">
	        <div class="caption">
	            <i class="fa fa-list font-green-sharp"></i>
	            <span class="caption-subject font-green-sharp bold uppercase">Lớp học có học viên</span>
	        </div>
	        <div class="actions">
	            <a href="{{ admin_url('work/my-student/course') }}" class="btn btn-circle green btn-sm">
	                <i class="fa fa-list"></i> Xem hết
	            </a>
	        </div>
	    </div>
	    <div class="portlet-body">
	        <div class="scroller" style="height: 339px;" data-always-visible="1" data-rail-visible="0">
	            <table class="table table-striped table-hover table-checkable order-column">
					<thead>
						<tr>
							<th width="50" class="table-checkbox text-center">
								<div class="checker">
									<span>
										<input type="checkbox" class="group-checkable">
									</span>
								</div>
							</th>
							<th class="text-center">STT</th>
							<th class="text-center">ID</th>
							<th>Lớp</th>
							<th class="text-center">Ngày khai giảng</th>
							<th class="text-center">Học phí</th>
						</tr>
					</thead>
					<tbody>
						@foreach($courses as $course_item)
							<tr class="pb-class-item hover-display-container">
								<th width="50" class="table-checkbox text-center">
									<div class="checker">
										<span>
											<input type="checkbox" class="group-checkable">
										</span>
									</div>
								</th>
								<td class="text-center"><strong>{{ $loop->index + 1 }}</strong></td>
								<td class="text-center"><strong>{{ $course_item->id }}</strong></td>
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
									Học viên của tôi: {{ $course_item->total_student }}
								</td>
			    				<td style="min-width: 200px">{{ text_time_difference($course_item->time_open) }}</td>
			    				<td class="text-center">
									{{ $course_item->price }} VND
								</td>
							</tr>
			            @endforeach
		            </tbody>
				</table>
	        </div>
	    </div>
	</div>
@endsection

@push('css')
	<link href="{{ asset_url('admin', 'global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
@endpush

@push('js_footer')
	<script type="text/javascript" src="{{ asset_url('admin', 'global/plugins/bootstrap-toastr/toastr.min.js') }}"></script>
@endpush
