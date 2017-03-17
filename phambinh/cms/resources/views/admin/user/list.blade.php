@extends('Cms::layouts.default',[
	'active_admin_menu' 	=> ['user', 'user.all'],
	'breadcrumbs' 			=> [
		'title'	=> [trans('user.user'), trans('user.list')],
		'url'	=> [
			route('admin.user.index')
		],
	],
])

@section('page_title', trans('user.list-user'))

@section('tool_bar')
	@can('admin.user.create')
		<a href="{{ route('admin.user.create') }}" class="btn btn-primary">
			<i class="fa fa-plus"></i> <span class="hidden-xs">@lang('user.add-new-user')</span>
		</a>
	@endcan
@endsection

@section('content')
	@component('Cms::components.table-function', [
		'total' 	=> $users->total(),
		'paginate' 	=> $users->appends($filter)->render(),
		'bulkactions' => [
			['action' => '', 'name' => ''],
			['action' => '', 'name' => ''],
			['action' => '', 'name' => ''],
		],
	])
		@slot('filter')
			<div class="row">
				<div class="col-sm-6 md-pr-0">
					<div class="form-group">
						<label class="control-label col-md-3">@lang('cms.search')</label>
						<div class="col-md-9">
							<input type="text" class="form-control" name="_keyword" value="{{ $filter['_keyword'] or '' }}" />
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3">@lang('user.role')</label>
						<div class="col-md-9">
							{!! Form::select('role_id', Phambinh\Cms\Role::get()->mapWithKeys(function ($item) {
								return [$item->id => $item->name];
							}), isset($filter['role_id']) ? $filter['role_id'] : NULL, ['class' => 'form-control', 'placeholder' => '']) !!}
						</div>
					</div>
				</div>
				<div class="col-sm-6 md-pl-0">
					<div class="form-group">
						<label class="control-label col-md-3">@lang('user.status')</label>
						<div class="col-md-9">
							{!! Form::select('status', \Phambinh\Cms\User::statusable()->mapWithKeys(function ($item) {
								return [$item['slug'] => $item['name']];
							})->all(), isset($filter['status']) ? $filter['status'] : NULL, ['class' => 'form-control', 'placeholder' => '']) !!}
						</div>
					</div>
				</div>
			</div>
		@endslot

		@slot('heading')
			<th width="50" class="table-checkbox text-center">
				{!! Form::icheck(null, null, ['class' => 'check-all']) !!}
			</th>
			<th class="text-center hidden-xs">
				{!! \Phambinh\Cms\User::linkSort('ID', 'id') !!}
			</th>
			<th>
				{!! \Phambinh\Cms\User::linkSort(trans('user.firstname'), 'first_name') !!}
			</th>
			<th class="hidden-xs">
				{!! \Phambinh\Cms\User::linkSort(trans('user.date_update'), 'updated_at') !!}
			</th>
			<th></th>
		@endslot

		@slot('data')
			@foreach($users as $user_item)
				<tr class="hover-display-container">
					<td width="50" class="table-checkbox text-center">
						{!! Form::icheck('id', $user_item->id, ['class' => 'check-all']) !!}
					</td>
					<td class="text-center hidden-xs"><strong>{{ $user_item->id }}</strong></td>
    				<td>
    					<div class="media">
			                <div class="pull-left">
			                    <img class="img-circle" src="{{ thumbnail_url($user_item->avatar, ['width' => '70', 'height' => '70']) }}" alt="" style="max-width: 70px" />
			                </div>

			                <div class="media-body">
			                    <ul class="info unstyle-list">
			                        <li class="name">
			                        	@can('admin.user.show')
			                        		<a href="{{ route('admin.user.show', ['id' => $user_item->id]) }}"><strong>{{ $user_item->full_name }}</strong></a>
			                        	@endcan
			                        	@cannot('admin.user.show', $user_item)
			                        		<strong>{{ $user_item->full_name }}</strong>
			                        	@endcannot
			                        	<span class="label label-sm label-info">
				                        	{{ $user_item->role_name }}
	                                        <i class="fa fa-share"></i>
	                                    </span>
		                        		<span class="hover-display pl-15 hidden-xs">
		                        			@can('admin.user.show', $user_item)
												<a href="#" remote-modal data-name="#popup-show-user" data-url="{{ route('admin.user.popup-show', ['id' => $user_item->id]) }}" class="text-sm"><i>@lang('cms.quick-view')</i></a>
											@endcan
										</span>
			                        </li>
			                        <li class="hidden-xs">NS: {{ $user_item->birth or trans('cms.empty') }}</li>
			                        <li class="hidden-xs">SĐT: {{ $user_item->phone or trans('cms.empty') }}</li>
			                        <li class="hidden-xs">Email: {{ $user_item->email or trans('cms.empty') }}</li>
			                    </ul>
			                </div>
			            </div>
    				</td>
    				<td style="min-width: 200px" class="hidden-xs">{{ $user_item->updated_at->diffForHumans() }}</td>
    				<td>
    					<div class="btn-group pull-right">
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
                            	@can('admin.user.show')
	                                <li><a href="{{ @route('admin.user.show', ['id' => $user_item->id]) }}"><i class="fa fa-eye"></i> @lang('cms.view')</a></li>
	                                <li role="presentation" class="divider"> </li>
                                @endcan

                                @if(!$user_item->isSelf())
	                                @can('admin.user.login-as')
		                                <li><a href="{{ route('admin.user.login-as', ['id' => $user_item->id]) }}"><i class="fa fa-sign-in"></i> @lang('user.login-as')</a></li>
		                                <li role="presentation" class="divider"> </li>
	                                @endcan

	                                @can('admin.user.edit', $user_item)
	                                	<li><a href="{{ route('admin.user.edit', ['id' => $user_item->id]) }}"><i class="fa fa-pencil"></i> @lang('cms.edit')</a></li>
	                                @endcan

	                                @can('admin.user.disable', $user_item)
		                            	@if($user_item->isEnable() && ! $user_item->isSelf($user_item->id))
		                            		<li><a data-function="disable" data-method="put" href="{{ route('admin.user.disable', ['id' => $user_item->id]) }}"><i class="fa fa-recycle"></i> @lang('cms.disable')</a></li>
		                            	@endif
	                            	@endcan
				
	                            	@if($user_item->isDisable())
	                            		@can('admin.user.enable', $user_item)
		                            		<li><a data-function="enable" data-method="put" href="{{ route('admin.user.enable', ['id' => $user_item->id]) }}"><i class="fa fa-recycle"></i> @lang('cms.enable')</a></li>
		                            		<li role="presentation" class="divider"></li>
	                            		@endcan

	                            		@can('admin.user.destroy')
	                            			<li><a data-function="destroy" data-method="delete" href="{{ route('admin.user.destroy', ['id' => $user_item->id]) }}"><i class="fa fa-times"></i> @lang('cms.delete')</a></li>
	                            		@endcan
	                            	@endif
                            	@endif
                            </ul>
                        </div>
    				</td>
				</tr>
			@endforeach
		@endslot
	@endcomponent
@endsection