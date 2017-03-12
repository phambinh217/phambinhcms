@php 
	if (!isset($level)) {
		$level = 0;
		$parent_id = '0';
	}
@endphp

@foreach($categories as $category_item)
	@php $has_child = $categories->where('parent_id', $category_item->id)->first();  @endphp
	@if($category_item->parent_id == $parent_id)
		<tr class="odd gradeX">
			<td width="50" class="table-checkbox text-center">
				<div class="checker">
					<input type="checkbox" class="icheck" value="{{ $category_item->id }}">
				</div>
			</td>
			<td class="text-center hidden-xs">
				<strong>
					{{ $category_item->id }}
				</strong>
			</td>
			<td><img src="{{ thumbnail_url($category_item->thumbnail, ['height' => '70', 'width' => '70']) }}" /></td>
			<td>
				@can('admin.ecommerce.category.edit', $category_item)
					<a href="{{ route('admin.ecommerce.category.edit', ['id' => $category_item->id]) }}">
						<strong>
							{{ str_repeat('—', $level) .' '. $category_item->name }}
						</strong>
					</a>
				@endcan
				@cannot('admin.ecommerce.category.edit', $category_item)
					<strong>
						{{ str_repeat('—', $level) .' '. $category_item->name }}
					</strong>
				@endcannot
				({{ $category_item->products->count() }} sản phẩm)
			</td>
			<td class="hidden-xs">
				{{ text_time_difference($category_item->created_at) }}
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
		            	@if(Route::has('product.category'))
			            	<li><a href="{{ route('product.category', ['slug' => $category_item->slug, 'id' => $category_item->id]) }}"><i class="fa fa-eye"></i> Xem</a></li>
			                <li role="presentation" class="divider"></li>
		                @endif
		                @can('admin.ecommerce.category.edit', $category_item)
			                <li><a href="{{ route('admin.ecommerce.category.edit', ['id' => $category_item->id]) }}"><i class="fa fa-pencil"></i> Sửa</a></li>
			                <li role="presentation" class="divider"></li>
		                @endcan
		                @can('admin.ecommerce.category.destroy', $category_item)
		            		<li><a data-function="destroy" data-method="delete" href="{{ route('admin.ecommerce.category.destroy', ['id' => $category_item->id]) }}"><i class="fa fa-times"></i> Xóa</a></li>
		            	@endcan
		            </ul>
		        </div>
			</td>
		</tr>
		@if($has_child)
			@include('Ecommerce::admin.components.category.table-items', [
				'categories' => $categories,
				'parent_id' => $category_item->id,
				'level' => $level + 1,
			])
		@endif
	@endif
@endforeach
