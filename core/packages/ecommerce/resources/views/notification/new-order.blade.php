@extends('Admin::layouts.email')

@section('header')
	<a style="{{ config('email-style.font-family') }} {{ config('email-style.email-masthead_name') }}" href="{{ url('/') }}" target="_blank">
		{{ config('app.name') }}
	</a>
@endsection

@section('main')
	<h1 style="{{ config('email-style.header-1') }}">Xin chào!</h1>
	<p style="{{ config('email-style.paragraph') }}">
		Hệ thống vừa tiếp nhận thêm một đơn hàng mới
		<ul>
			<li style="{{ config('email-style.paragraph') }}">Mã đơn hàng: #{{ $order->id }}</li>
			<li style="{{ config('email-style.paragraph') }}">Tài khoản đặt hàng: {{ $order->customer->name }}</li>
			<li style="{{ config('email-style.paragraph') }}">Người nhận hàng: {{ $order->last_name .' '. $order->first_name }}</li>
			<li style="{{ config('email-style.paragraph') }}">SĐT: {{ $order->phone }}</li>
			<li style="{{ config('email-style.paragraph') }}">Email: {{ $order->email }}</li>
			<li style="{{ config('email-style.paragraph') }}">Địa chỉ nhận hàng: {{ $order->address }}</li>
			<li style="{{ config('email-style.paragraph') }}">Tổng giá trị: {{ price_format($order->total) }}</li>
		</ul>
	</p>
	<table style="{{ config('email-style.body_action') }}" align="center" width="100%" cellpadding="0" cellspacing="0">
		<tr>
			<td align="center">
				<a href="{{ route('admin.sales.order.show', ['id' => $order->id]) }}" style="{{ config('email-style.font-family') }} {{ config('email-style.button') }}" class="button" target="_blank">
					Xem chi tiết đơn hàng
				</a>
			</td>
		</tr>
	</table>
	<p style="{{ config('email-style.paragraph') }}">
	 	Hãy nhanh chóng xử lí đơn hàng, để có thể bán được nhiều sản phẩm hơn bạn nhé. Chúc bạn một ngày tốt lành.
	</p>
	<p style="{{ config('email-style.paragraph') }}">
	 	Trân trọng,<br>{{ config('app.name') }}
	</p>
	<table style="{{ config('email-style.body-sub') }}">
		<tr>
			<td style="{{ config('email-style.font-family') }}">
				<p style="{{ config('email-style.paragraph-sub') }}">
					Nếu như bạn gặp vấn đề không thể click vào nút "{{ 'Action' }}",
					thì hãy copy và dán url dưới đây vào ô địa chỉ duyệt web của bạn:
				</p>

				<p style="{{ config('email-style.paragraph-sub') }}">
					<a style="{{ config('email-style.anchor') }}" href="{{ '#' }}" target="_blank">
						#
					</a>
				</p>
			</td>
		</tr>
	</table>
@endsection

@section('footer')
	<p style="{{ config('email-style.paragraph-sub') }}">
		&copy; {{ date('Y') }}
		<a style="{{ config('email-style.anchor') }}" href="{{ url('/') }}" target="_blank">{{ config('app.name') }}</a>.
		Giữ toàn quyền.
	</p>
@endsection