@extends('Home::layouts.default')

@section('content')
	<div class="ui container">
		<div class="ui grid">
			<div class="five wide column"></div>
			<div class="six wide column">
				<div class="ui segment">
					<h3 class="ui header">Đăng nhập</h3>
					<form class="ui form">
						<div class="field">
							<label>Email</label>
							<input type="text" name="email" placeholder="Email">
						</div>
						<div class="field">
							<label>Mật khẩu</label>
							<input type="password" name="password" placeholder="mật khẩu">
						</div>
						<div class="field">
							<div class="ui checkbox">
								<input type="checkbox" tabindex="0" class="hidden" name="remember">
								<label>Nhớ mật khẩu</label>
							</div>
						</div>
						<button class="ui button primary" type="submit">Đăng nhập</button>
					</form>
				</div>
				<a href="{{ route('customer.reset-password') }}">Quên mật khẩu</a> <a href="{{ route('customer.register') }}">Đăng ký tài khoản</a>
			</div>
		</div>
	</div>
@endsection