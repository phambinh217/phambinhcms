@extends('Home::layouts.default')

@section('content')
	<div class="ui container">
		<div class="ui massive breadcrumb">
			<a class="section" href="{{ url('/') }}">Trang chủ</a>
			<i class="right chevron icon divider"></i>
			<a class="section active">Liên hệ</a>
		</div>
		<div class="ui segment">
			<form class="ui form">
				<div class="field">
					<label for="">Tên bạn</label>
					<input type="text" name="full_name" value="" />
				</div>
				<div class="field">
					<label for="">Email</label>
					<input type="text" name="full_name" value="" />
				</div>
				<div class="field">
					<label for="">Chủ đề</label>
					<input type="text" name="full_name" value="" />
				</div>
				<div class="field">
					<label for="">Nội dung</label>
					<textarea name=""></textarea>
				</div>
				<button class="ui button primary">Gửi</button>
			</form>
		</div>
	</div>
@endsection