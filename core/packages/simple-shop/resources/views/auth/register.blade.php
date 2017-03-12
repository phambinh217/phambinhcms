@extends('Home::layouts.default')

@section('content')
	<div class="ui container">
		<div class="ui grid">
			<div class="five wide column"></div>
			<div class="six wide column">
				<div class="ui segment">
					<h3 class="ui header">Đăng ký</h3>
					<form class="ui form">
						<div class="field">
	                        <label>Địa chỉ email</label>
	                        <input type="text" name="email" placeholder="Email">
	                    </div>
	                    <div class="field">
	                        <label>Họ và tên</label>
	                        <input type="text" name="email" placeholder="Email">
	                    </div>
	                    <div class="field">
	                        <label>SĐT</label>
	                        <input type="text" name="email" placeholder="Email">
	                    </div>
	                    <div class="field">
	                        <label>Mật khẩu</label>
	                        <input type="password" name="password" placeholder="Mật khẩu">
	                    </div>
	                    <div class="field">
	                        <label>Nhập lại mật khẩu</label>
	                        <input type="password" name="password" placeholder="Mật khẩu">
	                    </div>
	                    <div class="field">
	                        <div class="ui checkbox">
	                            <input type="checkbox" tabindex="0" class="hidden">
	                            <label>Bấm vào đăng ký là bạn đồng ý với <a href="">điều khoản</a> của chúng tôi</label>
	                        </div>
	                    </div>
						<button class="ui button primary" type="submit">Đặt lại mật khẩu</button>
					</form>
				</div>
				<a href="{{ route('customer.login') }}">Đăng nhập</a> <a href="{{ route('customer.register') }}">Đăng ký tài khoản</a>
			</div>
		</div>
	</div>
@endsection