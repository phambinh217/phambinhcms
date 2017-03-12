@extends('Cms::layouts.default',[
	'active_admin_menu' 	=> ['user', 'user.all'],
	'breadcrumbs' 			=> [
		'title'	=> [trans('user.user'), trans('user.list'), trans('cms.view')],
		'url'	=> [
			route('admin.user.index'),
			route('admin.user.index'),
		],
	],
])

@section('page_title', trans('user.view-detail'))

@section('page_sub_title', $user->full_name)

@section('tool_bar')
	<a href="{{ route('admin.user.edit', ['id' => $user->id]) }}" class="btn btn-primary">
		<i class="fa fa-pencil"></i> <span class="hidden-xs">@lang('cms.edit')</span>
	</a>
@endsection

@section('content')

@endsection
