@extends('Cms::layouts.auth')

@section('content')
    <form class="login-form" action="{{ url('/login') }}" method="post" novalidate="novalidate">
    {{ csrf_field() }}
        <h3 class="form-title">Đăng nhập tài khoản</h3>
        <div class="alert alert-danger display-hide">
            <button class="close" data-close="alert"></button>
            <span> Nhập địa chỉ email và mật khẩu. </span>
        </div>
        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            <label class="control-label visible-ie8 visible-ie9">E-mail</label>
            <div class="input-icon">
                <i class="fa fa-user"></i>
                <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="E-mail" name="email">
            </div>
            @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            <label class="control-label visible-ie8 visible-ie9">Mật khẩu</label>
            <div class="input-icon">
                <i class="fa fa-lock"></i>
                <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Mật khẩu" name="password">
            </div>
            @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-actions">
            <label class="rememberme mt-checkbox mt-checkbox-outline">
                <input type="checkbox" name="remember" value="1"> Nhớ mật khẩu
                <span></span>
            </label>
            <button type="submit" class="btn green pull-right"> Đăng nhập </button>
        </div>
        <div class="forget-password">
            <h4>Quên mật khẩu ?</h4>
            <p> đừng lo, click
                <a href="{{ url('/password/reset') }}" id="forget-password"> vào đây </a> để lấy lại mật khẩu. </p>
        </div>
        <div class="create-account">
            <p> Bạn chưa có tài khoản ?&nbsp;
                <a href="{{ url('/register') }}" id="register-btn"> Tạo tài khoản </a>
            </p>
        </div>
    </form>
@endsection
