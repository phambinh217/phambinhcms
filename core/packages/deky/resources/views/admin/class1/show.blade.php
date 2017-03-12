@extends('Cms::layouts.default',[
	'active_admin_menu' 	=> ['work', 'work.my-class'],
	'breadcrumbs' 			=> [
		'title'	=> ['Công việc', 'Khóa học của tôi', 'Chi chiết khóa học'],
		'url'	=> [],
	],
])

@section('page_title', $course->title)

@section('content')

@endsection

@push('css')

@endpush

@push('js_footer')

@endpush
