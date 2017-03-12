@extends('Home::layouts.default')

@section('content')
	<div class="ui container">
		<div class="ui massive breadcrumb">
			<a class="section" href="{{ url('/') }}">Trang chủ</a>
			<i class="right chevron icon divider"></i>
			<a class="section active">Thanh toán</a>
		</div>
		<div class="ui ignored info message">
			<h1>Quan trọng - Xác nhận đơn hàng</h1>
			Đơn hàng của bạn đã được gửi đến chúng tôi. Tuy nhiên còn một bước nữa để xác nhận đơn hàng. Một email đã được gửi đến địa chỉ <code>{{ \Auth::user()->email }}</code>, bạn vui lòng truy cập vào hòm thư email để xác nhận đơn hàng.<br />
			Nếu không tìm thấy email, bạn vui lòng kiểm tra trong hộp thư spam. <br />
			Cảm ơn bạn đã tin tưởng mua sản phẩm trên hệ thống của chúng tôi.
		</div>
	</div>
@endsection
