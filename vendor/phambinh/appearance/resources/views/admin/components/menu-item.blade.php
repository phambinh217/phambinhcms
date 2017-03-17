@if(!isset($parent_id)) 
	@php $parent_id = 0; @endphp
@endif

@foreach($menu_items as $item)
	@if($item->parent_id == $parent_id)
		<li class="dd-item dd3-item" data-id="{{ $item->id }}">
			<div class="dd-handle dd3-handle"></div>
			<div class="dd3-content hover-display-container" data-parent="#menu-structor" data-toggle="collapse" data-target="#menu-item-{{ $item->id }}">
				{{ $item->title }}
				<span class="hover-display pl-15 hidden-xs pull-right">
					<a class="delete-menu-item" href="{{ route('admin.appearance.menu-item.destroy', ['id' => $item->id]) }}">Xóa</a>
				</span>
			</div>
			<div id="menu-item-{{ $item->id }}" class="collapse">
				{!! Form::ajax([
					'url' => route('admin.appearance.menu-item.update', ['id' => $item->id]),
					'method' => 'PUT',
					'class' => 'form-horizontal',
				]) !!}
					<div class="form-group">
						<label class="control-lalel col-sm-3">@lang('menu.name')</label>
						<div class="col-sm-9">
							<input name="menu_item[title]" type="text" class="form-control input-sm" value="{{ $item->title }}" />
						</div>
					</div>
					<div class="form-group">
						<label class="control-lalel col-sm-3">@lang('menu.url')</label>
						<div class="col-sm-9">
							<input name="menu_item[url]" type="text" class="form-control input-sm" value="{{ $item->url }}" />
						</div>
					</div>
					<div class="form-actions util-btn-margin-bottom-5 text-right">
						<button class="btn btn-primary btn-sm">
							@lang('cms.save')
						</button>
					</div>
				{!! Form::close() !!}
			</div>
			@if($item->hasChild())
				<ol class="dd-list">
					@include('Appearance::admin.components.menu-item', [
						'menu_items' => $menu_items,
						'parent_id' => $item->id,
					])
				</ol>
			@endif
		</li>
	@endif
@endforeach