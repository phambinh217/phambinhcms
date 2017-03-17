@extends('Cms::layouts.default',[
	'active_admin_menu' 	=> ['user', 'user.role'],
	'breadcrumbs' 			=> [
		'title'	=> [trans('user.user'), trans('user.role'), isset($role_id) ?  trans('cms.edit') : trans('cms.add-new')],
		'url'	=> [
			route('admin.user.index'),
			route('admin.role.index'),
		],
	],
])

@section('page_title', isset($role_id) ? trans('role.edit-role') : trans('role.add-new-role'))
@if(isset($role_id))
	@can('admin.role.create')
		@section('tool_bar')
			<a href="{{ route('admin.role.create') }}" class="btn btn-primary">
				<i class="fa fa-plus"></i> <span class="hidden-xs">@lang('role.add-new-role')</span>
			</a>
		@endsection
	@endcan
@endif
@section('content')
	{!! Form::ajax(['url' => isset($role_id) ? route('admin.role.update', ['id' => $role_id]) : route('admin.role.store'), 'method' => isset($role_id) ? 'PUT' : 'POST', 'class' => 'form-horizontal form-bordered form-row-stripped']) !!}
		<div class="form-body">
			<div class="form-group">
				<label class="control-label col-sm-2 pull-left">
					@lang('role.name') <span class="required">*</span>
				</label>
				<div class="col-sm-7">
					<input value="{{ $role->name or '' }}" name="role[name]" type="text" placeholder="" class="form-control">
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-sm-2 pull-left">
					@lang('role.type')<span class="required">*</span>
				</label>
				<div class="col-sm-7">
					{!! Form::select('role[type]', $role->typeable()->mapWithKeys(function ($item) {
						return [$item['id'] => $item['name']];
					})->all(), isset($role_id) ? $role->type : '*', ['class' => 'form-control width-auto']) !!}
				</div>
			</div>

			<div class="permission-list" style="{{ isset($role_id) && $role->type == 'option' ? '' : 'display: none' }}">
				<div class="form-group">
					<label class="control-label col-sm-2 pull-left"></label>
					<div class="col-sm-10">
						<div class="m-heading-1 border-green m-bordered">
							<?php $access_controls = collect(\AccessControl::all()); ?>
							@foreach($access_controls->chunk(3) as $chunks)
								<div class="row">
									@foreach($chunks as $access_item)
										<?php $check = isset($role_id) && in_array($access_item['ability'], (array) \AccessControl::getRole($role->id)['permissions']) ? 'checked' : '' ; ?>
										<div class="col-sm-4">
					                        <div class="input-group">
					                            <div class="icheck-list">
					                                <label>
					                                    <input {{ $check }} type="checkbox" class="icheck" name="role[permission][]" value="{{ $access_item['ability'] }}" /> {{ $access_item['name'] }}
													</label>
					                            </div>
					                        </div>
				                        </div>
			                        @endforeach
		                        </div>
	                        @endforeach
                        </div>
					</div>
				</div>				
			</div>
		</div>
		<div class="form-actions util-btn-margin-bottom-5">
			<div class="row">
				<div class="col-md-offset-2 col-md-10">
					@if(! isset($role_id))
						{!! Form::btnSaveNew() !!}
					@else
						{!! Form::btnSaveOut() !!}
					@endif
				</div>
			</div>
		</div>
	{!! Form::close() !!}
@endsection

@push('css')
	<link href="{{ asset_url('admin', 'global/plugins/icheck/skins/all.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push('js_footer')
	<script src="{{ asset_url('admin', 'global/plugins/icheck/icheck.min.js') }}" type="text/javascript"></script>
	<script type="text/javascript">
	$(function(){
		$('*[name="role[type]"]').change(function(){
			var roleType = $(this).val();
			switch(roleType) {
				case '*': case '0':
					$('.permission-list').hide();
				break;
				case 'option':
					$('.permission-list').show();
				break;
			}
		});
	});
	</script>
@endpush
