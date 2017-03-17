@extends('Cms::layouts.default',[
	'active_admin_menu' 	=> ['setting', 'setting.appearance', 'setting.appearance.menu'],
	'breadcrumbs' 			=> [
		'title'	=> [trans('setting.setting'), trans('menu.menu'), trans('cms.edit')],
		'url'	=> [
			route('admin.setting.general', route('admin.appearance.menu.index'))
		],
	],
])

@section('page_title', trans('menu.edit-menu'))
@section('page_sub_title', $menu->name)

@section('content')
	<div class="row">
		<div class="col-sm-4">
			<div class="portlet-group">
				@foreach(\Menu::all() as $menu_item)
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption">
							<span class="caption-subject bold">{{ $menu_item['name'] }}</span>
						</div>
						<div class="tools">
							<a href="javascript:;" class="expand"> </a>
							<a href="" class="fullscreen"> </a>
						</div>
					</div>
					<div class="portlet-body" style="display: none;">
						{!! Form::ajax([
							'url' => route('admin.appearance.menu.add', ['id' => $menu_id]),
							'method' => 'POST',
							'class' => 'form-horizontal',
						]) !!}
							<div class="form-body"  style="margin: 15px 0;">
								<div class="scroller" style="height:200px;" data-rail-visible="1" data-rail-color="yellow" data-handle-color="#a1b2bd">
									<input type="hidden" name="type" value="{{ $menu_item['type'] }}">
									@include('Appearance::admin.components.form-checkbox-menu-item', [
										'items' => $menu_item['type']::get(),
										'name' => 'object_id[]',
									])
								</div>
							</div>
							<div class="form-actions util-btn-margin-bottom-5">
								<button class="btn btn-primary full-width-xs">
									<i class="fa fa-plus"></i> @lang('cms.add')
								</button>
							</div>
						{!! Form::close() !!}
					</div>
				</div>
				@endforeach
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption">
							<span class="caption-subject bold">@lang('menu.custom-link')</span>
						</div>
						<div class="tools">
							<a href="javascript:;" class="collapse"> </a>
							<a href="" class="fullscreen"> </a>
						</div>
					</div>
					<div class="portlet-body">
						{!! Form::ajax([
							'url' => route('admin.appearance.menu.add-default', ['id' => $menu_id]),
							'method' => 'POST',
						]) !!}
							<div class="form-body">
								<input type="hidden" name="type" value="custom-link">
								<div class="form-group">
									<label class="control-label">@lang('menu.name')</label>
									<input name="menu_item[title]" type="text" class="form-control" />
								</div>
								<div class="form-group">
									<label class="control-label">@lang('menu.url')</label>
									<input name="menu_item[url]" type="text" class="form-control" />
								</div>
							</div>
							<div class="form-actions util-btn-margin-bottom-5">
								<button class="btn btn-primary full-width-xs">
									<i class="fa fa-plus"></i> @lang('cms.add')
								</button>
							</div>
						{!! Form::close() !!}
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-8">
			<div class="portlet light bordered form-fit">
				<div class="portlet-title with-tab">
					<div class="tab-default">
						<ul class="nav nav-tabs">
							<li class="active">
								<a href="#menu-struct" data-toggle="tab" aria-expanded="true"> @lang('menu.struct') </a>
							</li>
							<li class="">
								<a href="#menu-info" data-toggle="tab" aria-expanded="false"> @lang('menu.menu') </a>
							</li>
						</ul>
					</div>
				</div>
				<div class="portlet-body form">
					<div class="tab-content">
						<div class="tab-pane active" id="menu-struct">
							<div class="dd" id="menu-structor" style="padding: 15px">
								<ol class="dd-list">
									@include('Appearance::admin.components.menu-item', [
										'menu_items' => $menu->items->sortBy('order'),
									])
								</ol>
							</div>
							<div class="form-actions util-btn-margin-bottom-5" style="padding: 15px">
								{!! Form::ajax([
									'url' => route('admin.appearance.menu.update.struct', ['id' => $menu_id]),
									'method' => 'PUT',
									'class' => 'form-horizontal form-bordered',
								]) !!}									
									<input type="hidden" name="menu[struct]" value="" />
									<button class="btn btn-primary full-width-xs">
										<i class="fa fa-save"></i> @lang('cms.save')
									</button>
								{!! Form::close() !!}
							</div>
						</div>
						<div class="tab-pane" id="menu-info">
							{!! Form::ajax([
								'url' => route('admin.appearance.menu.update', ['id' => $menu_id]),
								'method' => 'PUT',
								'class' => 'form-horizontal form-bordered',
							]) !!}
								<div class="form-body">
									<div class="form-group">
										<label class="control-label col-sm-3">
											@lang('menu.name')
										</label>
										<div class="col-sm-9">
											<input type="text" name="menu[name]" class="form-control" value="{{ $menu->name }}" />
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-3">
											@lang('menu.slug')
										</label>
										<div class="col-sm-9">
											<input type="text" name="menu[slug]" class="form-control" value="{{ $menu->slug }}" />
											<label class="checkbox-inline">
												<input type="checkbox" value="true" checked="" id="create-slug">
												@lang('menu.from-menu-name')
											</label>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-3">
											@lang('menu.location')
										</label>
										<div class="col-sm-9">
											{!! Form::select('menu[location]', \Menu::location()->mapWithKeys(function ($item) {
												return [$item['id'] => $item['name']];
											})->all(), $menu->location, ['class' => 'form-control', 'placeholder' => '']) !!}
										</div>
									</div>
								</div>
								<div class="form-actions util-btn-margin-bottom-5">
									<button class="btn btn-primary full-width-xs">
										<i class="fa fa-save"></i> @lang('cms.save-change')
									</button>
								</div>
							{!! Form::close() !!}
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@addCss('css', asset_url('admin', 'global/plugins/jquery-nestable/jquery.nestable.css'))
@addJs('js_footer', asset_url('admin', 'global/plugins/jquery-nestable/jquery.nestable.js'))
@push('js_footer')
    <script type="text/javascript">
    	$(function(){
    		$('#menu-structor').nestable().on('change', function(e){
    			$('input[name="menu[struct]"]').val(getMenuStruct());
    		});
    		function getMenuStruct() {
    			return JSON.stringify($('#menu-structor').nestable('serialize'));
    		}
    		function updateStruct() {
    			$('input[name="menu[struct]"]').val(getMenuStruct());
    		}
    		updateStruct();
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

			$('.delete-menu-item').click(function(e){
				e.preventDefault();
				if (!confirm('Bạn có chắc muốn xóa')) {
					return false;
				}
				var url = $(this).attr('href');
				$.ajax({
					url: url,
					dataType: 'json',
					type: 'post',
					data: {
						_token: csrfToken(),
						_method: 'DELETE',
					},
				});
			});
    	});
    </script>
@endpush
