@extends('Home::layouts.default')

@section('content')
	<div class="ui container">
		<div class="ui massive breadcrumb">
			<a class="section" href="{{ url('/') }}">Trang chủ</a>
			<i class="right chevron icon divider"></i>
			<a class="section active">Liên hệ</a>
		</div>
		<div class="ui segment">
			<div class="ui ignored info message">
				Chúng tôi đã nhận được thông tin liên hệ của bạn. Chúng tôi sẽ sớm có phản hồi cho bạn. Cảm ơn!
			</div>
			<a href="{{ url('/') }}" class="ui button primary">Về trang chủ</a>
		</div>
	</div>
@endsection