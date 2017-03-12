@php 
	if (!isset($level)) {
		$level = 0;
		$parent_id = '0';
	}
@endphp

@foreach($filters as $filter_item)
	@php $has_child = $filters->where('parent_id', $filter_item->id)->first();  @endphp
	@if($filter_item->parent_id == $parent_id)
		<tr class="odd gradeX">
			<td width="50" class="table-checkbox text-center">
				<div class="checker">
					<input type="checkbox" class="icheck" value="{{ $filter_item->id }}">
				</div>
			</td>
			<td class="text-center hidden-xs">
				<strong>
					{{ $filter_item->id }}
				</strong>
			</td>
			<td><img src="{{ thumbnail_url($filter_item->thumbnail, ['height' => '70', 'width' => '70']) }}" /></td>
			<td>
				@can('admin.ecommerce.filter.edit', $filter_item)
					<a href="{{ route('admin.ecommerce.filter.edit', ['id' => $filter_item->id]) }}">
						<strong>
							{{ str_repeat('—', $level) .' '. $filter_item->name }}
						</strong>
					</a>
				@endcan
				@cannot('admin.ecommerce.filter.edit', $filter_item)
					<strong>
						{{ str_repeat('—', $level) .' '. $filter_item->name }}
					</strong>
				@endcannot
				({{ $filter_item->products->count() }} sản phẩm)
			</td>
			<td class="hidden-xs">
				{{ text_time_difference($filter_item->created_at) }}
			</td>
			<td>
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
		            	@if(Route::has('product.filter'))
			            	<li><a href="{{ route('product.filter', ['slug' => $filter_item->slug, 'id' => $filter_item->id]) }}"><i class="fa fa-eye"></i> Xem</a></li>
			                <li role="presentation" class="divider"> </li>
		                @endif
		                @can('admin.ecommerce.filter.edit', $filter_item)
			                <li><a href="{{ route('admin.ecommerce.filter.edit', ['id' => $filter_item->id]) }}"><i class="fa fa-pencil"></i> Sửa</a></li>
			            	<li role="presentation" class="divider"></li>
		            	@endcan
		            	@can('admin.ecommerce.filter.destroy', $filter_item)
		            		<li><a data-function="destroy" data-method="delete" href="{{ route('admin.ecommerce.filter.destroy', ['id' => $filter_item->id]) }}"><i class="fa fa-times"></i> Xóa</a></li>
		            	@endcan
		            </ul>
		        </div>
			</td>
		</tr>
		@if($has_child)
			@include('Ecommerce::admin.components.filter.table-items', [
				'filters' => $filters,
				'parent_id' => $filter_item->id,
				'level' => $level + 1,
			])
		@endif
	@endif
@endforeach
