@extends('Home::layouts.default')

@section('content')
	<div class="ui container">
		<div class="ui massive breadcrumb">
			<a class="section" href="{{ url('/') }}">Trang chủ</a>
			<i class="right chevron icon divider"></i>
			<a class="section active">Trang cá nhân</a>
		</div>
		<h1 class="ui header">
			Đổi thông tin cá nhân
		</h1>
		<div class="ui grid">
			<div class="four wide column">
				@include('Home::partials.sidebar-profile')
			</div>
			<div class="ten wide column">
				<form class="ui form" method="post" id="form-profile" action="{{ route('profile.update') }}">
					{{ csrf_field() }}
					{{ method_field('PUT') }}
					<div class="field">
						<label>Họ và tên <span class="required">*</span></label>
						<div class="two fields">
							<div class="field">
								<input type="text" name="user[last_name]" placeholder="Họ và tên đệm" value="{{ \Auth::user()->last_name }}">
							</div>
							<div class="field">
								<input type="text" name="user[first_name]" placeholder="Tên" value="{{ \Auth::user()->first_name }}">
							</div>
						</div>
					</div>
					<div class="field">
						<label for="">Email <span class="required">*</span></label>
						<input type="text" name="user[email]" value="{{ \Auth::user()->email }}" />
					</div>
					<div class="field">
						<label for="">Số điện thoại <span class="required">*</span></label>
						<input type="text" name="user[phone]" value="{{ \Auth::user()->phone }}" />
					</div>
					<div class="field">
						<label for="">Địa chỉ <span class="required">*</span></label>
						<textarea name="user[address]">{{ \Auth::user()->address }}</textarea>
					</div>
					<div class="field">
						<label for="">Ngày sinh <span class="required">*</span></label>
						<input type="text" name="user[birth]" value="{{ changeFormatDate(\Auth::user()->birth, DF_DB, DF_NORMAL) }}" />
					</div>
					<button type="submit" class="ui button primary">Lưu thay đổi</button>
				</form>
			</div>
		</div>
	</div>
@endsection
@push('css')
	<link rel="stylesheet" href="{{ asset_url('baseshop', 'app/vendors/toastr/toastr.css') }}">
@endpush
@push('js_footer')
	<script type="text/javascript" src="{{ asset_url('baseshop', 'app/vendors/toastr/toastr.min.js') }}"></script>
	<script type="text/javascript">
		$(function() {
			handleAjaxForm('#form-profile', function(res){
				toastr.success(res.message, res.title);
			});
		});
	</script>
@endpush