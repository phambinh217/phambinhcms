@extends('Cms::layouts.default', [
	'active_admin_menu'	=> ['course', 'course.category'],
	'breadcrumbs'		=>	[
		'title' => ['Khóa học', 'Danh mục'],
		'url'	=> [
			route('admin.course.index'),
		],
	],	
])

@section('page_title', 'Danh mục khóa học')

@section('tool_bar')
	<a href="{{ route('admin.course.category.create') }}" class="btn btn-primary full-width-xs">
		<i class="fa fa-plus"></i> <span class="hidden-xs">Thêm danh mục mới</span>
	</a>
@endsection

@section('content')
<div class="table-function-container">
	<div class="row">
		<div class="col-sm-6 table-above">
			<div class="form-inline filter">
				<div style="display: inline" category-apply-form>
					<div class="form-group">
						<select class="form-control input-sm" category-apply-action>
							<option value="0"></option>
							<option value="">Xóa tạm</option>
						</select>
					</div>
					<div class="form-group">
						<button class="btn btn-primary btn-sm" category-apply-btn>Áp dụng</button>
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-6 text-right">
			{!!$categories->setPath('category')->appends($filter)->render()!!}
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
						{!! $category->linkSort('ID', 'id') !!}
					</th>
					<th>Thumbnail</th>
					<th>
						{!! $category->linkSort('Tên danh mục', 'title') !!}
					</th>
					<th>
						{!! $category->linkSort('Ngày tạo', 'created_at') !!}
					</th>
					<th> Thao tác </th>
				</tr>
			</thead>
			<tbody>
				@foreach($categories as $category_item)
				<tr class="odd gradeX">
					<td width="50" class="table-checkbox text-center">
						<div class="checker">
							<input type="checkbox" class="icheck" value="{{ $category_item->id }}">
						</div>
					</td>
					<td class="text-center">
						<strong>
							{{ $category_item->id }}
						</strong>
					</td>
					<td><img src="{{ thumbnail_url($category_item->thumbnail, ['height' => '70', 'width' => '70']) }}" /></td>
					<td>
						<a href="{{ route('admin.course.category.edit', ['id' => $category_item->id]) }}">
							<strong>
								{{ $category_item->name }}
							</strong>
						</a>
						({{ $category_item->courses()->count() }} khóa học)
					</td>
					<td>
						{{ text_time_difference($category_item->created_at) }}
					</td>
					<td category-action>
						<div class="btn-group" table-function>
                            <a href="" class="btn btn-circle btn-xs grey-salsa btn-sm dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
											<span class="hidden-xs">
				                            	@lang('cms.action')
				                                <span class="fa fa-angle-down"> </span>
			                                </span>
			                                <span class="visible-xs">
			                                	<span class="fa fa-cog"> </span>
			                                </span>
                                <span class="fa fa-angle-down"> </span>
                            </a>
                            <ul class="dropdown-menu pull-right">
                            	<li><a href="{{ route('admin.course.category.show', ['id' => $category_item->id]) }}"><i class="fa fa-eye"></i> Xem</a></li>
                                <li role="presentation" class="divider"> </li>
                                <li><a href="{{ route('admin.course.category.edit', ['id' => $category_item->id]) }}"><i class="fa fa-pencil"></i> Sửa</a></li>
                            	<li><a data-function="destroy" data-method="delete" href="{{ route('admin.course.category.destroy', ['id' => $category_item->id]) }}"><i class="fa fa-times"></i> Xóa</a></li>
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