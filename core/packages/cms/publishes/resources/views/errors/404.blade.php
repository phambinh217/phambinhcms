@extends('layouts.app')

@php \Metatag::set('title', '404'); @endphp

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="alert alert-info">
            	<h1>Lỗi 404</h1>
            	<p>Trang web bạn truy cập không tồn tại</p>
                <p>Gợi ý hỗ trợ
                    <ul>
                        <li><a href="{{ url('/contact') }}">Liên hệ quản trị viên</a></li>
                        <li><a href="{{ setting('forum-support-link') }}">Diễn đàn hỗ trợ</a></li>
                    </ul>
                </p>
            	<p class="">
            		<a href="{{ url('/') }}" class="btn btn-primary">Trang chủ</a>
            		<a class="btn btn-default" href="{{ url('/logout') }}"
                        onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                        Đăng xuất
                    </a>
            	</p>
            </div>
        </div>
    </div>
</div>
@endsection
