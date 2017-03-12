@extends('Admin::layouts.email')

@section('header')
	<a style="{{ config('email-style.font-family') }} {{ config('email-style.email-masthead_name') }}" href="{{ url('/') }}" target="_blank">
		{{ setting('company-name') }}
	</a>
@endsection

@section('main')
	<h1 style="{{ config('email-style.header-1') }}">Xin chào {{ $customer->full_name }}!</h1>
	<p style="{{ config('email-style.paragraph') }}">
		Cảm ơn bạn đã tin tưởng đặt mua sản phẩm tại cửa hàng website <a href="{{ url('/') }}">{{ url('/') }}</a> của chúng tôi. <br />
		Dưới đây là thông tin về đơn hàng của bạn. Nếu như bạn cảm thấy hài lòng thì hãy nhấp vào nút "xác nhận đơn hàng" phía dưới để hoàn tất quá trình đặt hàng<br />
	<table style="{{ config('email-style.table') }}">
		<thead>
			<tr>
				<th style="{{ config('email-style.table-th') }}">#</th>
				<th style="{{ config('email-style.table-th') }}">Sản phẩm</th>
				<th style="{{ config('email-style.table-th') }}">Đơn giá</th>
				<th style="{{ config('email-style.table-th') }}">Số lượng</th>
				<th style="{{ config('email-style.table-th') }}">Tổng</th>
			</tr>
		</thead>
		<tbody>
			@foreach($order->products as $product_item)
				<tr>
					<td style="{{ config('email-style.table-td')  }}">{{ $loop->index + 1 }}</td>
					<td style="{{ config('email-style.table-td')  }}">
						{{ $product_item->name }} <br />
						@if($order->productOptions->count())
							@php $options = $order->productOptions->groupBy('option_id'); @endphp
							@foreach($options as $option_item)
								<small>{{ $option_item->first()->name }}: {{ $option_item->implode('value', ', ') }}</small><br />
							@endforeach
                        @endif
					</td>
					<td style="{{ config('email-style.table-td')  }}">{{ price_format($product_item->price) }}</td>
					<td style="{{ config('email-style.table-td')  }}">{{ $product_item->quantity }}</td>
					<td style="{{ config('email-style.table-td')  }}">{{ price_format($product_item->quantity * $product_item->price) }}</td>
				</tr>
			@endforeach
			@foreach($order->details as $detai_item)
				<tr>
					<td colspan="2"></td>
					<td colspan="2" style="{{ config('email-style.table-td')  }}">{{ $detai_item->name }}</td>
					<td style="{{ config('email-style.table-td')  }}">{{ price_format($detai_item->value) }}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
	<table style="{{ config('email-style.body_action') }}" align="center" width="100%" cellpadding="0" cellspacing="0">
		<tr>
			<td align="center">
				<a href="{{ route('checkout.confirm-order', ['id' => $order->id, 'confirm_token' => $order->confirm_token]) }}" style="{{ config('email-style.font-family') }} {{ config('email-style.button') }}" class="button" target="_blank">
					Xác nhận đơn hàng
				</a>
			</td>
		</tr>
	</table>
	<p style="{{ config('email-style.paragraph') }}">
	 	Đây là một email quan trọng, chúng tôi khuyên bạn không nên xóa email này cho đến khi nhận được sản phẩm.
	</p>
	<p style="{{ config('email-style.paragraph') }}">
	 	Trân trọng,<br>{{ setting('company-name') }}
	</p>
	<table style="{{ config('email-style.body-sub') }}">
		<tr>
			<td style="{{ config('email-style.font-family') }}">
				<p style="{{ config('email-style.paragraph-sub') }}">
					Nếu như bạn gặp vấn đề không thể click vào nút Xác nhận đơn hàng,
					thì hãy copy và dán url dưới đây vào ô địa chỉ duyệt web của bạn:
				</p>

				<p style="{{ config('email-style.paragraph-sub') }}">
					<a style="{{ config('email-style.anchor') }}" href="{{ '#' }}" target="_blank">
						{{ route('checkout.confirm-order', ['id' => $order->id, 'confirm_token' => $order->confirm_token]) }}
					</a>
				</p>
			</td>
		</tr>
	</table>
@endsection

@section('footer')
	<p style="{{ config('email-style.paragraph-sub') }}">
		&copy; {{ date('Y') }}
		<a style="{{ config('email-style.anchor') }}" href="{{ url('/') }}" target="_blank">{{ setting('company-name') }}</a>.
		Giữ toàn quyền.
	</p>
@endsection