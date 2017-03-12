@extends('Cms::layouts.default', [
	'active_admin_menu'	=> [ 'ecommerce', ' ecommerce.tag', ' ecommerce.tag.index'],
	'breadcrumbs'		=>	[
		'title' => ['Danh mục', 'Danh sách thẻ'],
		'url'	=> [
			route('admin.ecommerce.tag.index')
		],
	],	
])

@section('page_title', 'Thẻ sản phẩm')

@section('tool_bar')
	<a href="{{ route('admin.ecommerce.tag.create') }}" class="btn btn-primary">
		<i class="fa fa-plus"></i> <span class="hidden-xs">Thêm thẻ mới</span>
	</a>
@endsection

@section('content')	
<div class="table-function-container">
	<div class="note note-success">
		<p><i class="fa fa-info"></i> Tổng số {{ $tags->count() }} kết quả</p>
	</div>
	<div class="row table-above">
		<div class="col-sm-6">
			<div class="form-inline mb-10 apply-action">
				@include('Cms::components.form-apply-action', [
					'actions' => [
						['action' => route('admin.ecommerce.tag.multiple-destroy'), 'name' => 'Xóa vĩnh viễn', 'method' => 'DELETE'],
					],
				])
				</div>
			</div>
			<div class="col-sm-6 text-right table-page"></div>
		</div>
		<table class="master-table table table-striped table-hover table-checkable order-column pb-items">
			<thead>
				<tr>
					<th width="50" class="table-checkbox text-center">
						<div class="checker">
							<input type="checkbox" class="icheck check-all">
						</div>
					</th>
					<th class="text-center hidden-xs" width="50">
						{!! \Packages\Ecommerce\Tag::linkSort('ID', 'id') !!}
					</th>
					<th class="text-center">
						Ảnh
					</th>
					<th>
						{!! \Packages\Ecommerce\Tag::linkSort('Tên', 'name') !!}
					</th>
					<th class="text-center hidden-xs">
						{!! \Packages\Ecommerce\Tag::linkSort('Ngày tạo', 'created_at') !!}
					</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				@foreach($tags as $tag_item)
					<tr class="odd gradeX">
						<td width="50" class="table-checkbox text-center">
							<div class="checker">
								<input type="checkbox" class="icheck" value="{{ $tag_item->id }}">
							</div>
						</td>
						<td class="text-center hidden-xs" width="50">
							<strong>
								{{ $tag_item->id }}
							</strong>
						</td>
						<td><img src="{{ thumbnail_url($tag_item->thumbnail, ['height' => '70', 'width' => '70']) }}" /></td>
						<td>
							<a href="{{ route('admin.ecommerce.tag.edit', ['id' => $tag_item->id]) }}">{{ $tag_item->name }}</a>
							({{ $tag_item->products->count() }} sản phẩm)
						</td>
						<td class="text-center hidden-xs">
							{{ text_time_difference($tag_item->created_at) }}
						</td>
						<td tag_item-action class="text-right">
							<div class="btn-group" table-function>
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
									<li><a href="{{ route('admin.ecommerce.tag.edit', ['id' => $tag_item->id]) }}"><i class="fa fa-pencil"></i> Sửa</a></li>
									<li class="divider"></li>
									<li><a data-function="destroy" data-method="delete" href="{{ route('admin.ecommerce.tag.destroy', ['id' => $tag_item->id]) }}"><i class="fa fa-times"></i> Xóa</a></li>
								</ul>
							</div>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
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