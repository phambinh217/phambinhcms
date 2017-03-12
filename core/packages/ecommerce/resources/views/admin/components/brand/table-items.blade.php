@php 
	if (!isset($level)) {
		$level = 0;
		$parent_id = '0';
	}
@endphp

@foreach($brands as $brand_item)
	@php $has_child = $brands->where('parent_id', $brand_item->id)->first();  @endphp
	@if($brand_item->parent_id == $parent_id)
		<tr class="odd gradeX">
			<td width="50" class="table-checkbox text-center">
				<div class="checker">
					<input type="checkbox" class="icheck" value="{{ $brand_item->id }}">
				</div>
			</td>
			<td class="text-center hidden-xs">
				<strong>
					{{ $brand_item->id }}
				</strong>
			</td>
			<td><img src="{{ thumbnail_url($brand_item->thumbnail, ['height' => '70', 'width' => '70']) }}" /></td>
			<td>
				@can('admin.ecommerce.brand.edit', $brand_item)
					<a href="{{ route('admin.ecommerce.brand.edit', ['id' => $brand_item->id]) }}">
						<strong>
							{{ str_repeat('—', $level) .' '. $brand_item->name }}
						</strong>
					</a>
				@endcan
				@cannot('admin.ecommerce.brand.edit', $brand_item)
					<strong>
						{{ str_repeat('—', $level) .' '. $brand_item->name }}
					</strong>
				@endcannot
				({{ $brand_item->products->count() }} sản phẩm)
			</td>
			<td class="hidden-xs">
				{{ text_time_difference($brand_item->created_at) }}
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
		            	@if(Route::has('product.brand'))
			            	<li><a href="{{ route('product.brand', ['slug' => $brand_item->slug, 'id' => $brand_item->id]) }}"><i class="fa fa-eye"></i> Xem</a></li>
			                <li role="presentation" class="divider"> </li>
		                @endif
		                
		                @can('admin.ecommerce.brand.edit', $brand_item)
			                <li><a href="{{ route('admin.ecommerce.brand.edit', ['id' => $brand_item->id]) }}"><i class="fa fa-pencil"></i> Sửa</a></li>
			            	<li role="presentation" class="divider"></li>
		            	@endcan
		            	@cannot('admin.ecommerce.brand.destroy', $brand_item)
		            		<li><a data-function="destroy" data-method="delete" href="{{ route('admin.ecommerce.brand.destroy', ['id' => $brand_item->id]) }}"><i class="fa fa-times"></i> Xóa</a></li>
		            	@endcannot
		            </ul>
		        </div>
			</td>
		</tr>
		@if($has_child)
			@include('Ecommerce::admin.components.brand.table-items', [
				'brands' => $brands,
				'parent_id' => $brand_item->id,
				'level' => $level + 1,
			])
		@endif
	@endif
@endforeach
