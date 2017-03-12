@extends('Home::layouts.default')

@section('content')
	<div class="ui container">
		<div class="ui massive breadcrumb">
			<a class="section" href="{{ url('/') }}">Trang chủ</a>
			<i class="right chevron icon divider"></i>
			<a class="section active">Hòm thư</a>
		</div>
		<table class="ui celled padded table">
			<thead>
				<th>#</th>
				<th>Chủ đề</th>
				<th>Người gửi</th>
				<th>Nhận lúc</th>
				<th></th>
			</thead>
			<tbody>
				@foreach(\Auth::user()->inbox()->get() as $mail_item)
					<tr>
						<td>{{ $loop->index + 1 }}</td>
						<td>{{ $mail_item->subject }}</td>
						<td></td>
						<td>{{ changeFormatDate($mail_item->created_at) }}</td>
						<td>
							<button data-id="{{ $mail_item->id }}" class="ui button mini" read-mail>Đọc</button>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
@endsection

@push('html_footer')
<div class="ui modal" id="read-mail-modal">
	 <div class="header">Đọc thư</div>
	<div class="content" id="mail-message">

	</div>
	<div class="actions">
		<div class="ui cancel button">Đóng</div>
	</div>
</div>
@endpush

@push('js_footer')
<script type="text/javascript">
	$(function(){
		$('*[read-mail]').click(function(e){
			e.preventDefault();
			$('#read-mail-modal').modal('show');
		});
	});
</script>
@endpush