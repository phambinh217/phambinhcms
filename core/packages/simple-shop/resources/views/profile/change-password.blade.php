@extends('Home::layouts.default')

@section('content')
	<div class="ui container">
		<div class="ui massive breadcrumb">
			<a class="section" href="{{ url('/') }}">Trang chủ</a>
			<i class="right chevron icon divider"></i>
			<a class="section active">Trang cá nhân</a>
		</div>
		<h1 class="ui header">
			Đổi mật khẩu
		</h1>
		<div class="ui grid">
			<div class="four wide column">
				@include('Home::partials.sidebar-profile')
			</div>
			<div class="ten wide column">
				<form class="ui form" id="form-change-password" method="post">
					{{ method_field('PUT') }}
					{{ csrf_field() }}
					<div class="field">
						<label for="">Mật khẩu cũ</label>
						<input type="password" name="user[old_passowrd]" />
					</div>
					<div class="field">
						<label for="">Mật khẩu mới</label>
						<input type="password" name="user[passowrd]" />
					</div>
					<div class="field">
						<label for="">Nhập lại mật khẩu</label>
						<input type="password" name="user[password_confirmation]" />
					</div>
					<button class="ui button primary">Đổi mật khẩu</button>
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
			handleAjaxForm('#form-change-password', function(res){
				toastr.success(res.message, res.title);
			});
		});
	</script>
@endpush