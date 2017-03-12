@foreach($menu_items as $menu_item)
	@if($menu_item->parent_id == $parent_id)
		@php $has_child = $menu_items->where('parent_id', $menu_item->id)->count(); @endphp
		@if($has_child)
			<div class="ui left pointing dropdown link item">
				<a href="{{ $menu_item->url }}" style="color: #000">{{ $menu_item->title }}</a>
				<i class="dropdown icon"></i>
				<div class="menu">
					@include('Home::components.nav-menu-item', [
						'menu_items' => $menu_items,
						'parent_id' => $menu_item->id,
						'level' => $level + 1,
					])
				</div>
			</div>
		@else
			<a href="{{ $menu_item->url }}" class="item">{{ $menu_item->title }}</a>
		@endif
	@endif
@endforeach