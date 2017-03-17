@extends('Cms::layouts.default',[
	'active_admin_menu' 	=> ['user', 'user.role'],
	'breadcrumbs' 			=> [
		'title'	=> [trans('user.user'), trans('user.role')],
		'url'	=> [
			route('admin.user.index'),
		],
	],
])

@section('page_title', trans('user.role'))
@can('admin.role.create')
	@section('tool_bar')
		<a href="{{ route('admin.role.create') }}" class="btn btn-primary">
			<i class="fa fa-plus"></i> <span class="hidden-xs">@lang('role.add-new-role')</span>
		</a>
	@endsection
@endcan
@section('content')
	@component('Cms::components.table-function', [
		'total' => $roles->total(),
		'bulkactions' => [
			['action' => '', 'name' => trans('cms.destroy')],
		],
		'paginate' => $roles->setPath('role')->appends($filter)->render()
	])
		@slot('heading')
			<th width="50" class="table-checkbox text-center">
				{!! Form::icheck(null, null, ['class' => 'check-all']) !!}
			</th>
			<th class="text-center hidden-xs">
				{!! \Phambinh\Cms\Role::linkSort(trans('role.id'), 'id') !!}
			</th>
			<th>
				{!! \Phambinh\Cms\Role::linkSort(trans('role.name'), 'name') !!}
			</th>
			<th class="text-center hidden-xs">
				{!! \Phambinh\Cms\Role::linkSort(trans('role.total-user'), 'total_user') !!}
			</th>
			<th class="hidden-xs">
				{!! \Phambinh\Cms\Role::linkSort(trans('role.date-update'), 'updated_at') !!}
			</th>
			<th></th>
		@endslot

		@slot('data')
			@foreach($roles as $role_item)
				<tr class="pb-role-item hover-display-container">
					<td width="50" class="table-checkbox text-center">
						{!! Form::icheck('id', $role_item->id, ['class' => 'check-all']) !!}
					</td>
					<td class="text-center hidden-xs"><strong>{{ $role_item->id }}</strong></td>
    				<td>
    					@can('admin.role.edit', $role_item)
	    					<a href="{{ route('admin.role.edit', ['id' => $role_item->id]) }}">
	    						<strong>{{ $role_item->name }}</strong>
	    					</a>
    					@endcan
    					@cannot('admin.role.edit', $role_item)
    						<strong>{{ $role_item->name }}</strong>
    					@endcannot
    				</td>
    				<td class="text-center hidden-xs">
    					<strong>
    						{{ $role_item->total_user }}
    					</strong>
    				</td>
    				<td class="hidden-xs" style="min-width: 200px">{{ $role_item->updated_at->diffForHumans() }}</td>
    				<td table-action>
						<div class="btn-group">
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
                            	@can('admin.role.edit', $role_item)
	                                <li><a href="{{ route('admin.role.edit', ['id' => $role_item->id]) }}"><i class="fa fa-pencil"></i> @lang('cms.edit')</a></li>
	                                <li role="presentation" class="divider"> </li>
                                @endcan
                                @can('admin.role.destroy', $role_item)
                            		<li><a data-function="destroy" data-method="delete" href="{{ route('admin.role.destroy', ['id' => $role_item->id]) }}"><i class="fa fa-times"></i> @lang('cms.destroy')</a></li>
                            	@endcan
                            </ul>
                        </div>
					</td>
				</tr>
			@endforeach
		@endslot
	@endcomponent
@endsection