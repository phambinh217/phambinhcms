@extends('Cms::layouts.default',[
	'active_admin_menu' 	=> ['setting', 'setting.appearance', 'setting.appearance.menu'],
	'breadcrumbs' 			=> [
		'title'	=> [trans('setting.setting'), trans('menu.appearance'), trans('menu.menu')],
		'url'	=> [
			route('admin.setting.general', route('admin.appearance.menu.index'))
		],
	],
])

@section('page_title', trans('menu.list-menu'))

@section('content')
<div class="row">
	<div class="col-sm-4">
		@can('admin.appearance.menu.create')
			<div class="portlet light bordered">
				<div class="portlet-title">
					<div class="caption">
						<span class="caption-subject bold">@lang('menu.add-new-menu')</span>
					</div>
					<div class="tools">
						<a href="javascript:;" class="collapse"> </a>
						<a href="" class="fullscreen"> </a>
					</div>
				</div>
				<div class="portlet-body">
					{!! Form::ajax([
						'url' => route('admin.appearance.menu.store'),
						'method' => 'POST',
						'class' => 'form-horizontal',
					]) !!}
						<div class="form-body">
							<div class="form-group">
								<label class="control-label col-sm-3 pull-left">
									@lang('menu.name')
								</label>
								<div class="col-sm-9">
									<input type="text" name="menu[name]" class="form-control" />
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-3 pull-left">
									@lang('menu.slug')
								</label>
								<div class="col-sm-9">
									<input type="text" name="menu[slug]" class="form-control" />
									<label class="checkbox-inline">
										<input type="checkbox" value="true" checked="" id="create-slug">
										@lang('menu.from-menu-name')
									</label>
								</div>
							</div>
						</div>
						<div class="form-actions util-btn-margin-bottom-5">
							<button class="btn btn-primary full-width-xs">
								<i class="fa fa-save"></i> @lang('cms.add')
							</button>
						</div>
					{!! Form::close() !!}
				</div>
			</div>
		@endcan
	</div>
	<div class="col-sm-8">
		@component('Cms::components.table-function')
			@slot('heading')
				<th width="50" class="table-checkbox text-center">
					<div class="checker">
						{!! Form::icheck(null, null, ['class' => 'check-all']) !!}
					</div>
				</th>
				<th class="text-center">@lang('menu.id')</th>
				<th>@lang('menu.name')</th>
				<th class="hidden-xs">@lang('menu.location')</th>
				<th></th>
			@endslot
			@slot('data')
				@foreach($menus as $menu_item)
					<tr>
						<td width="50" class="table-checkbox text-center">
							{!! Form::icheck('id', $menu_item->id) !!}
						</td>
						<td class="text-center"><strong>{{ $menu_item->id }}</strong></td>
						<td>
							@can('admin.appearance.menu.edit', $menu_item)
								<a href="{{ route('admin.appearance.menu.edit', ['id' => $menu_item->id]) }}">
									<strong>{{ $menu_item->name }}</strong>
								</a>
							@endcan

							@cannot('admin.appearance.menu.edit', $menu_item)
								<strong>{{ $menu_item->name }}</strong>
							@endcannot
						</td>
						<td class="hidden-xs">{{ $menu_item->location('name') }}</td>
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
									@can('admin.appearance.menu.edit', $menu_item)
										<li><a href="{{ route('admin.appearance.menu.edit', ['id' => $menu_item->id]) }}"><i class="fa fa-pencil"></i> @lang('cms.edit')</a></li>
										<li class="divider"></li>
									@endcan
									@can('admin.appearance.menu.destroy', $menu_item)
										<li><a data-function="destroy" data-method="delete" href="{{ route('admin.appearance.menu.destroy', ['id' => $menu_item->id]) }}"><i class="fa fa-times"></i> @lang('cms.destroy')</a></li>
									@endcan
								</ul>
							</div>
						</td>
					</tr>
				@endforeach
			@endslot
		@endcomponent
	</div>
</div>
@endsection

@push('js_footer')
	<script type="text/javascript">
		$(function(){
			$('#create-slug').click(function() {
				if(this.checked) {
					var title = $('input[name="menu[name]"]').val();
					var slug = strSlug(title);
					$('input[name="menu[slug]"]').val(slug);
				}
			});

			$('input[name="menu[name]"]').keyup(function() {
				if ($('#create-slug').is(':checked')) {
					var title = $(this).val();
					var slug = strSlug(title);
					$('input[name="menu[slug]"]').val(slug);	
				}
			});
		});
	</script>
@endpush
