@extends('Home::layouts.default')

@section('content')
	<div class="ui container">
		<div class="ui massive breadcrumb">
			<a class="section" href="{{ url('/') }}">Trang chủ</a>
			<i class="right chevron icon divider"></i>
			<a class="section active">Thanh toán</a>
		</div>
		<div class="ui ignored warning message">
			<h1>Đơn hàng không thể xác nhận.</h1>
			Chúng tôi rất tiếc. Nhưng đã có một sự cố xảy ra với đơn hàng của bạn. <br />
			Vui lòng liên hệ số điện thoại hỗ trợ {{ setting('company-phone') }}
		</div>
		
	</div>
@endsection