@extends('Cms::layouts.default', [
	'active_admin_menu'	=> ['news', 'news.category'],
	'breadcrumbs'		=>	[
		'title' => [trans('news.news'), trans('news.category.category')],
		'url'	=> [
			route('admin.news.index'),
		],
	],	
])

@section('page_title', trans('news.news-category'))

@section('tool_bar')
	@can('admin.news.category.create')
		<a href="{{ route('admin.news.category.create') }}" class="btn btn-primary">
			<i class="fa fa-plus"></i> <span class="hidden-xs">@lang('news.category.add-new-category')</span>
		</a>
	@endcan
@endsection

@section('content')
	@component('Cms::components.table-function', [
		'total' => $categories->total(),
		'bulkactions' => [
			['action' => '', 'name' => trans('cms.destroy'), 'method' => 'DELETE'],
		],
	])
		@slot('heading')
			<th width="50" class="table-checkbox text-center">
				{!! Form::icheck(null, null, ['class' => 'check-all']) !!}
			</th>
			<th class="text-center">
				{!! \Packages\News\Category::linkSort(trans('news.category.id'), 'id') !!}
			</th>
			<th>Thumbnail</th>
			<th>
				{!! \Packages\News\Category::linkSort(trans('news.category.title'), 'title') !!}
			</th>
			<th>
				{!! \Packages\News\Category::linkSort(trans('news.category.date_update'), 'updated_at') !!}
			</th>
			<th></th>
			
		@endslot

		@slot('data')
			@include('News::admin.components.category-table-item', [
				'categories' => $categories,
			])
		@endslot
	@endcomponent
@endsection
