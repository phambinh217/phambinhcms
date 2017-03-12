<div class="ui menu inverted">
	@php $menu_items = menu_items('master-menu'); @endphp
	@foreach($menu_items as $menu_item)
		@if($menu_item->parent_id == 0)
			@php $has_child = $menu_items->where('parent_id', $menu_item->id)->count(); @endphp
			@if($has_child)
				<div class="item ui dropdown menu-dropdown">
					{{ $menu_item->title }}
					<div class="menu">
						@include('Home::components.nav-menu-item', [
							'menu_items' => $menu_items,
							'parent_id' => $menu_item->id,
							'level' => '1'
						])
					</div>
				</div>
			@else
				<a class="item " href="{{ $menu_item->url }}">
					{{ $menu_item->title }}
				</a>
			@endif
		@endif
	@endforeach
</div>

@push('js_footer')
	<script type="text/javascript">
		$(function(){
			$('.menu-dropdown').dropdown({
		    	on: 'hover'
		  	});
		});
	</script>
@endpush