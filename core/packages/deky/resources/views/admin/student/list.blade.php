@extends('Cms::layouts.default',[
	'active_admin_menu' 	=> ['student', 'student.all'],
	'breadcrumbs' 			=> [
		'title'	=> ['Quản trị viên', 'Danh sách'],
		'url'	=> [
			admin_url('student'),
			admin_url('student'),
		],
	],
])

@section('page_title', 'Danh sách học viên')

@section('tool_bar')
	<a href="{{ route('admin.student.create') }}" class="btn btn-primary full-width-xs">
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
	        <form action="#" class="form-horizontal form-bordered form-row-stripped">
	            <div class="form-body">
	                <div class="row">
	                    <div class="col-sm-6 md-pr-0">
	                        <div class="form-group">
	                            <label class="control-label col-md-3">ID</label>
	                            <div class="col-md-9">
	                                <input type="text" name="id" placeholder="ID" value="{{ isset($filter['id']) ? $filter['id'] : '' }}" class="form-control" />
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
	                            <label class="control-label col-md-3">Trạng thái</label>
	                            <div class="col-md-9">
	                                <select name="status" class="form-control select2_category">
	                                    <option value="0">-- Chọn --</option>
	                                    @foreach([
	                                    	['id' 	=> 'enable',
	                                    	'name'	=>	'Bình thường'],
	                                    	['id' 	=> 'disable',
	                                    	'name'	=>	'Cấm',]
	                                    ] as $status_item)
	                                    	<option {{ isset($filter['status']) && $filter['status'] == $status_item['id'] ? 'selected' : '' }} value="{{ $status_item['id'] }}">{{ $status_item['name'] }}</option>
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
	                            <i class="fa fa-filter"></i> Lọc</button>
	                        <a href="{{ admin_url('student') }}" class="btn btn-gray full-width-xs">
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
	<div class="row">
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
		<table class="master-table table table-striped table-hover table-checkable order-column pb-students">
			<thead>
				<tr>
					<th width="50" class="table-checkbox text-center">
						<div class="checker">
									<input type="checkbox" class="icheck check-all">
								</div>
					</th>
					<th class="text-center">
						{!! $student->linkSort('ID', 'id') !!}
					</th>
					<th>
						{!! $student->linkSort('Họ và tên', 'first_name') !!}
					</th>
					<th>
						{!! $student->linkSort('Đã học', 'total_class') !!}
					</th>
					<th>
						{!! $student->linkSort('Ngày đăng ký', 'created_at') !!}
					</th>
					<th></th>
				</tr>
			</thead>
			<tbody class="pb-students">
				@foreach($students as $student_item)
					<tr class="pb-student-item hover-display-container">
						<td width="50" class="table-checkbox text-center">
							<div class="checker">
								<input type="checkbox" class="icheck" value="{{ $student_item->id }}">
							</div>
						</td>
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
			                        		<span class="hover-display pl-15">
												<a href="#" remote-modal data-name="#popup-show-user" data-url="{{ route('admin.user.popup-show', ['id' => $student_item->id]) }}" class="text-sm"><i>Xem nhanh |</i></a>
												<a href="" class="text-sm"><i>Gửi tin nhắn</i></a>
											</span>
				                        </li>
				                        <li>NS: {{ $student_item->birth or trans('cms.empty') }}</li>
				                        <li>SĐT: {{ $student_item->phone or trans('cms.empty') }}</li>
				                        <li>Email: {{ $student_item->email or trans('cms.empty') }}</li>
				                    </ul>
				                </div>
				            </div>
	    				</td>
	    				<td style="min-width: 100px">
							<a href="">
								<strong>{{ $student_item->total_class }} Lớp</strong> 
							</a>
						</td>
	    				<td style="min-width: 200px">{{ text_time_difference($student_item->created_at) }}</td>
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
	                                <li><a href="{{ route('admin.student.edit', ['id' => $student_item->id]) }}"><i class="fa fa-pencil"></i> Sửa</a></li>
	                            	@if($student_item->isEnable() && ! $student_item->isSelf($student_item->id))
	                            		<li><a data-function="disable" data-method="put" href="{{ route('admin.student.disable', ['id' => $student_item->id]) }}"><i class="fa fa-recycle"></i> Xóa tạm</a></li>
	                            	@endif

	                            	@if($student_item->isDisable())
	                            		<li><a data-function="enable" data-method="put" href="{{ route('admin.student.enable', ['id' => $student_item->id]) }}"><i class="fa fa-recycle"></i> Khôi phục</a></li>
	                            		<li role="presentation" class="divider"></li>
	                            		<li><a data-function="destroy" data-method="delete" href="{{ route('admin.student.destroy', ['id' => $student_item->id]) }}"><i class="fa fa-times"></i> Xóa</a></li>
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