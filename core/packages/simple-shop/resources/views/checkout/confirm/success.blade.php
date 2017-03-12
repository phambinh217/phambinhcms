@extends('Home::layouts.default')

@section('content')
	<div class="ui container">
		<div class="ui massive breadcrumb">
			<a class="section" href="{{ url('/') }}">Trang chủ</a>
			<i class="right chevron icon divider"></i>
			<a class="section active">Thanh toán</a>
		</div>
		<div class="ui ignored success message">
			<h1>Xác nhận thành công</h1>
			Đơn hàng của bạn đã được chuyển sang trạng thái <code>{{ $order->status->name }}</code>. Chúng tôi sẽ sớm xử lí đơn hàng của bạn. <br />
			<a href="{{ route('profile.history-order') }}">Kiểm tra trạng thái đơn hàng của bạn</a><br />
		</div>
		
	</div>
@endsection