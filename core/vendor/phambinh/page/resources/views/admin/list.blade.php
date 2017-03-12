@extends('Cms::layouts.default', [
	'active_admin_menu'	=> ['page', 'page.index'],
	'breadcrumbs' 		=> [
		'title'	=>	[trans('page.page'), trans('page.list')],
		'url'	=>	[
			route('admin.page.index'),
		],
	],
])

@section('page_title', trans('page.list-page'))

@section('tool_bar')
	@can('admin.page.create')
		<a href="{{ route('admin.page.create') }}" class="btn btn-primary">
			<i class="fa fa-plus"></i> <span class="hidden-xs">@lang('page.add-new-page')</span>
		</a>
	@endcan
@endsection

@section('content')
	@component('Cms::components.table-function', [
		'total' => $pages->total(),
		'pagiate' => $pages->appends($filter)->render(),
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
                        <label class="control-label col-md-3">@lang('page.status')</label>
                        <div class="col-md-9">
                        	{!! Form::select('status', \Phambinh\Page\Page::statusable()->mapWithKeys(function ($item) {
								return [$item['slug'] => $item['name']];
							})->all(), isset($filter['status']) ? $filter['status'] : NULL, ['class' => 'form-control', 'placeholder' => '']) !!}
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 md-pl-0">
                    <div class="form-group">
                        <label class="control-label col-md-3">@lang('page.author')</label>
                        <div class="col-md-9">
                            {!! Form::findUser('author_id', isset($filter['author_id']) ? $filter['author_id'] : null) !!}
                        </div>
                    </div>
                </div>
            </div>
		@endslot

		@slot('heading')
			<th width="50" class="table-checkbox text-center">
				{!! Form::icheck(null, null, ['class' => 'check-all']) !!}
			</th>
			<th width="50" class="text-center">
				{!! \Phambinh\Page\Page::linkSort(trans('id'), 'id') !!}
			</th>
			<th>
				{!! \Phambinh\Page\Page::linkSort(trans('title'), 'title') !!}
			</th>
			<th>
				@lang('page.author')
			</th>
			<th>
				{!! \Phambinh\Page\Page::linkSort(trans('date_update'), 'updated_at') !!}
			</th>
			<th class="text-center"></th>
		@endslot

		@slot('data')
			@foreach($pages as $page_item)
				<tr class="odd gradeX hover-display-container {{ $page_item->html_class }}">
					<td width="50" class="table-checkbox text-center">
						<div class="checker">
							<input type="checkbox" class="icheck" value="{{ $page_item->id }}">
						</div>
					</td>
					<td class="text-center">
						<strong>{{ $page_item->id }}</strong>
					</td>
					<td>
						@can('admin.page.edit', $page_item)
							<a href="{{ route('admin.page.edit', ['id' => $page_item->id]) }}">
								<strong>{{ $page_item->title }}</strong>
							</a>
						@endcan
						@cannot('admin.page.edit', $page_item)
							<strong>{{ $page_item->title }}</strong>
						@endcannot
					</td>
					<td>
						<img class="img-circle" style="width: 30px;" src="{{ thumbnail_url($page_item->author->avatar, ['width' =>50, 'height' => 50]) }}" alt="" /> {{ $page_item->author->full_name }}
					</td>
					<td>
						{{ $page_item->updated_at->diffForHumans() }}
					</td>

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
	                        	@if(Route::has('page.show'))
	                            	<li><a href="{{ route('page.show', ['slug' => $page_item->slug, 'id' => $page_item->id]) }}"><i class="fa fa-eye"></i> @lang('cms.view')</a></li>
	                            	<li role="presentation" class="divider"></li>
	                            @endif

	                            @can('admin.page.edit', $page_item)
		                            <li><a href="{{ route('admin.page.edit',['id' => $page_item->id]) }}"><i class="fa fa-pencil"></i> @lang('cms.edit')</a></li>
		                            <li role="presentation" class="divider"></li>
		                        @endcan
	                        	
	                        	@can('admin.page.disable', $page_item)
		                        	@if($page_item->isEnable())
		                        		<li><a data-function="disable" data-method="put" href="{{ route('admin.page.disable', ['id' => $page_item->id]) }}"><i class="fa fa-recycle"></i> @lang('cms.disable')</a></li>
		                        	@endif
	                        	@endcan

	                            @if($page_item->isDisable())
	                        		@can('admin.page.enable', $page_item)
	                            		<li><a data-function="enable" data-method="put" href="{{ route('admin.page.enable', ['id' => $page_item->id]) }}"><i class="fa fa-recycle"></i> @lang('cms.enable')</a></li>
	                            		<li role="presentation" class="divider"></li>
	                            	@endcan

	                            	@can('admin.page.destroy', $page_item)
	                            		<li><a data-function="destroy" data-method="delete" href="{{ route('admin.page.destroy', ['id' => $page_item->id]) }}"><i class="fa fa-times"></i> @lang('cms.destroy')</a></li>
	                            	@endcan
	                        	@endif
	                        </ul>
	                    </div>
					</td>
				</tr>
			@endforeach
		@endslot
	@endcomponent
@endsection
