@extends('Cms::layouts.default', [
	'active_admin_menu'	=> ['document', 'document.all'],
	'breadcrumbs' 		=> [
		'title'	=>	['Bài viết', 'Danh sách'],
		'url'	=>	[
			admin_url('document'),
			admin_url('document'),
		],
	],
])

@section('page_title', 'Tất cả bài viết')

@section('tool_bar')
	@can('admin.document.create')
		<a href="{{ route('admin.document.create') }}" class="btn btn-primary">
			<i class="fa fa-plus"></i> <span class="hidden-xs">Thêm bài viết mới</span>
		</a>
	@endcan
@endsection

@section('content')
	<div class="table-function-container">
	   	<div class="portlet light bordered">
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
		                            <label class="control-label col-md-3">Từ khóa</label>
		                            <div class="col-md-9">
		                                 <input type="text" class="form-control" name="_keyword" value="{{ $filter['_keyword'] or '' }}" />
		                            </div>
		                        </div>
		                        <div class="form-group">
		                            <label class="control-label col-md-3">Phiên bản</label>
		                            <div class="col-md-9">
		                                @include('Document::admin.components.form-select-version', [
	                                		'versions' =>  Packages\Document\Version::get(),
	                                		'name' => 'version_id',
	                                		'selected' => isset($filter['version_id']) ? $filter['version_id'] : '0',
	                                	])
		                            </div>
		                        </div>
		                    </div>
		                    <div class="col-sm-6 md-pl-0">
		                        <div class="form-group">
		                            <label class="control-label col-md-3">Trạng thái</label>
		                            <div class="col-md-9">
		                            	@include('Document::admin.components.form-select-status', [
					                        'statuses' => Packages\Document\Document::statusable()->all(),
					                        'name' => 'status',
					                        'selected' => isset($filter['status']) ? $filter['status'] : null,
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
		                    </div>
		                </div>
		            </div>
		            <div class="form-actions util-btn-margin-bottom-5">
		                <div class="row">
		                    <div class="col-md-12 text-right">
		                        <button type="submit" class="btn btn-primary">
		                            <i class="fa fa-filter"></i> Lọc
								</button>
		                        <a href="{{ admin_url('document') }}" class="btn default accordion-toggle">
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
		    	{!! $documents->appends($filter)->render() !!}
		    </div>
	    </div>
	    <div class="note note-success">
	        <p><i class="fa fa-info"></i> Tổng số {{ $documents->total() }} kết quả</p>
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
							{!! \Packages\Document\Document::linkSort('ID', 'id') !!}
						</th>
						<th class="text-center">
							{!! \Packages\Document\Document::linkSort('Tên bài viết', 'title') !!}
						</th>
						<th>
							Tác giả
						</th>
						<th>
							{!! \Packages\Document\Document::linkSort('Ngày cập nhật', 'updated_at') !!}
						</th>
						<th class="text-center">Thao tác</th>
					</tr>
				</thead>
				<tbody>
					@foreach($documents as $document_item)
					<tr class="odd gradeX hover-display-container {{ $document_item->html_class }}">
						<td width="50" class="table-checkbox text-center">
							<div class="checker">
								<input type="checkbox" class="icheck" value="{{ $document_item->id }}">
							</div>
						</td>
						<td class="text-center">
							<strong>{{ $document_item->id }}</strong>
						</td>
						<td>
							@can('admin.document.edit', $document_item)
								<a href="{{ route('admin.document.edit', ['id' => $document_item->id]) }}">
									<strong>{{ $document_item->title }}</strong>
								</a>
							@endcan
							@cannot('admin.document.edit', $document_item)
								<strong>{{ $document_item->title }}</strong>
							@endcannot
						</td>
						<td>
							<img class="img-circle" style="width: 30px;" src="{{ thumbnail_url($document_item->author->avatar, ['width' =>50, 'height' => 50]) }}" alt="" /> {{ $document_item->author->full_name }}
						</td>
						<td>
							{{ text_time_difference($document_item->updated_at) }}
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
		                        	@if(Route::has('document.show'))
		                            	<li><a href="{{ route('document.show', ['slug' => $document_item->slug, 'id' => $document_item->id]) }}"><i class="fa fa-eye"></i> Xem</a></li>
		                            	<li role="presentation" class="divider"></li>
		                            @endif
		                            
		                            @can('admin.document.edit', $document_item)
			                            <li><a href="{{ route('admin.document.edit',['id' => $document_item->id]) }}"><i class="fa fa-pencil"></i> Sửa</a></li>
			                            <li role="presentation" class="divider"></li>
			                        @endcan
		                        	
		                        	@can('admin.document.disable', $document_item)
			                        	@if($document_item->isEnable())
			                        		<li><a data-function="disable" data-method="put" href="{{ route('admin.document.disable', ['id' => $document_item->id]) }}"><i class="fa fa-recycle"></i> Xóa tạm</a></li>
			                        	@endif
		                        	@endcan
	
		                            @if($document_item->isDisable())
		                        		@can('admin.document.enable', $document_item)
		                            		<li><a data-function="enable" data-method="put" href="{{ route('admin.document.enable', ['id' => $document_item->id]) }}"><i class="fa fa-recycle"></i> Khôi phục</a></li>
		                            		<li role="presentation" class="divider"></li>
		                            	@endcan

		                            	@can('admin.document.destroy', $document_item)
		                            		<li><a data-function="destroy" data-method="delete" href="{{ route('admin.document.destroy', ['id' => $document_item->id]) }}"><i class="fa fa-times"></i> Xóa</a></li>
		                            	@endcan
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