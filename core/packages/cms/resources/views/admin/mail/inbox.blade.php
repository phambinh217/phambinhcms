@extends('Cms::layouts.default',[
	'active_admin_menu' 	=> ['mail', 'mail.inbox'],
	'breadcrumbs' 			=> [
		'title'	=> ['Tin nhắn', 'Hộp thư đến'],
		'url'	=> [
			admin_url('mail')
		],
	],
])

@section('page_title', 'Hộp thư đến')

@section('tool_bar')
	<a href="{{ route('admin.mail.create') }}" class="btn btn-primary">
        <i class="fa fa-plus"></i> <span class="hidden-xs">Soạn tin mới</span>
    </a>
@endsection

@section('content')
	<div class="portlet light bordered">
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
	                            <label class="control-label col-md-3">Chủ đề</label>
	                            <div class="col-md-9">
	                                <input type="text" name="subject" placeholder="Chủ đề" value="{{ isset($filter['subject']) ? $filter['subject'] : '' }}" class="form-control" />
	                            </div>
	                        </div>
	                        <div class="form-group">
	                            <label class="control-label col-md-3">Người gửi</label>
	                            <div class="col-md-9">
	                                <select name="receiver_id" id="select2-button-addons-single-input-group-sm" class="form-control find-user">
				                        <option value="0">-- Tìm kiếm --</option>
				                        @if(! empty($filter['receiver_id']))
				                            <option selected="" value="{{ $filter['receiver_id'] }}">{{ Packages\Cms\User::select('first_name', 'last_name')->find($filter['receiver_id'])->full_name }}</option>
				                        @endif
				                    </select>
				                    <span class="help-block">
				                        Nhập <code>ID</code>, hoặc <code>Email</code> hoặc <code>Số điện thoại</code> để tìm kiếm<br />
				                    </span>
	                            </div>
	                        </div>
	                    </div>
	                    <div class="col-sm-6 md-pl-0">
	                    	<div class="form-group">
	                            <label class="control-label col-md-3">Nhận lúc</label>
	                            <div class="col-md-9">
	                                <input type="text" name="created_at" placeholder="Nhận lúc" value="{{ isset($filter['created_at']) ? $filter['created_at'] : '' }}" class="form-control" />
	                            </div>
	                        </div>
	                        <div class="form-group">
	                            <label class="control-label col-md-3">Đã xem</label>
	                            <div class="col-md-9">
	                                <select name="check" class="form-control select2_category">
	                                    <option value="0">-- Chọn --</option>
	                                    @foreach([
	                                    	['id' 	=> 'checked',
	                                    	'name'	=>	'Đã xem'],
	                                    	['id' 	=> 'not-check',
	                                    	'name'	=>	'Chưa xem',]
	                                    ] as $check_item)
	                                    	<option {{ isset($filter['check']) && $filter['check'] == $check_item['id'] ? 'selected' : '' }} value="{{ $check_item['id'] }}">{{ $check_item['name'] }}</option>
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
	                        <button type="submit" class="btn btn-primary">
	                            <i class="fa fa-filter"></i> Lọc</button>
	                        <a href="{{ route('admin.mail.inbox') }}" class="btn btn-gray">
	                            <i class="fa fa-times"></i> Hủy
	                        </a>
	                    </div>
	                </div>
	            </div>
	        </form>
	    </div>
	</div>
	
		<div class="table-function-container">
		<div class="note note-success">
            <p><i class="fa fa-info"></i> Tổng số {{ $mails->total() }} kết quả</p>
        </div>
		<div class="row">
		    <div class="col-sm-6">
		    	<div class="form-inline mb-10">
			    	<div class="form-group">
			    		<select class="form-control">
			    			<option></option>
			    			<option>Xóa tạm</option>
			    		</select>
			    	</div>
			    	<div class="form-group">
			    		<button class="btn btn-primary">Áp dụng</button>
			    	</div>
			    </div>
		    </div>
		    <div class="col-sm-6 text-right">
		    	{!! $mails->appends($filter)->render() !!}
		    </div>
	    </div>
		<table class="master-table table table-striped table-hover table-checkable order-column pb-mails">
			<thead>
				<tr>
					<th width="50" class="table-checkbox text-center">
						<div class="checker">
									<input type="checkbox" class="icheck check-all">
								</div>
					</th>
					<th class="text-center">
						{!! $mail->linkSort('ID', 'id') !!}
					</th>
					<th style="min-width: 300px">
						{!! $mail->linkSort('Chủ đề', 'subject') !!}
					</th>
					<th>
						{!! $mail->linkSort('Người gửi', 'first_name') !!}
					</th>
					<th>
						{!! $mail->linkSort('Thời gian', 'created_at') !!}
					</th>
					<th></th>
				</tr>
			</thead>
			<tbody class="pb-mails">
				@foreach($mails as $mail_item)
					<tr class="pb-mail-item hover-display-container">
						<th width="50" class="table-checkbox text-center">
								<div class="checker">
									<input type="checkbox" class="icheck check-all">
								</div>
							</th>
						<td class="text-center"><strong>{{ $mail_item->id }}</strong></td>
						<td>
							<a href="{{ route('admin.mail.outbox.show', ['id' => $mail_item->id]) }}"><strong>{{ $mail_item->subject }}</strong></a>
							@if($mail_item->check == 0)
								<span class="label label-sm label-info"> Chưa đọc
	                                <i class="fa fa-share"></i>
	                            </span>
                            @endif
                            <span class="hover-display pl-15">
								<a href="{{ route('admin.mail.outbox.show', ['id' => $mail_item->id]) }}" class="text-sm"><i>Đọc</i></a>
							</span>
							<br />
							{{ str_limit($mail_item->content, 100) }}
						</td>
	    				<td>
	    					<div class="media">
				                <div class="pull-left">
				                    <img class="img-circle" src="{{ thumbnail_url($mail_item->avatar, ['width' => '50', 'height' => '50']) }}" alt="" style="max-width: 70px" />
				                </div>

				                <div class="media-body">
				                    <ul class="info unstyle-list">
				                        <li class="name"><a href=""><strong>{{ $mail_item->full_name() }}</strong></a></li>
				                        <li class="email"><i>{{ $mail_item->email }}</i></li>
				                    </ul>
				                </div>
				            </div>
	    				</td>
	    				<td style="min-width: 200px">{{ text_time_difference($mail_item->created_at) }}</td>
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
	                                <li><a href="{{ route('admin.mail.outbox.show', ['id' => $mail_item->id]) }}"><i class="fa fa-eye"></i> Xem</a></li>
                                	{{-- <li role="presentation" class="divider"> </li>
                            		<li><a data-function="destroy" data-method="delete" href="{{ '' }}"><i class="fa fa-times"></i> Xóa</a></li> --}}
	                            </ul>
	                        </div>
	    				</td>
					</tr>
				@endforeach
			</tbody>
		</table>
		<div class="row">
		    <div class="col-sm-6">
		    	<div class="form-inline mb-10">
			    	<div class="form-group">
			    		<select class="form-control">
			    			<option></option>
			    			<option>Xóa tạm</option>
			    		</select>
			    	</div>
			    	<div class="form-group">
			    		<button class="btn btn-primary">Áp dụng</button>
			    	</div>
			    </div>
		    </div>
		    <div class="col-sm-6 text-right">
		    	{!! $mails->render() !!}
		    </div>
	    </div>
    </div>
@endsection

@push('css')

@endpush

@push('js_footer')

@endpush

@include('Cms::component.find-user')