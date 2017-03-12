@extends('Home::layouts.default')

@section('content')
	<div class="ui container">
		<div class="ui grid">
			<div class="five wide column"></div>
			<div class="six wide column">
				<div class="ui segment">
					<h3 class="ui header">Đặt lại mật khẩu</h3>
					<form class="ui form">
						<div class="field">
							<label>Email</label>
							<input type="text" name="email" placeholder="Email">
						</div>
						<button class="ui button primary" type="submit">Đặt lại mật khẩu</button>
					</form>
				</div>
				<a href="{{ route('customer.login') }}">Đăng nhập</a> <a href="{{ route('customer.register') }}">Đăng ký tài khoản</a>
			</div>
		</div>
	</div>
@endsection