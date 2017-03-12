@extends('Cms::layouts.auth')

@section('content')
<form class="register-form" action="{{ url('/register') }}" method="post" novalidate="novalidate" style="display: block;">
    {{ csrf_field() }}
    <h3>Đăng ký</h3>
    <p> Nhập thông tin dưới đây để đăng ký: </p>
    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
        <label class="control-label visible-ie8 visible-ie9">Email</label>
        <div class="input-icon">
            <i class="fa fa-envelope"></i>
            <input class="form-control placeholder-no-fix" type="text" placeholder="Email" name="email">
        </div>
        @if ($errors->has('email'))
            <span class="help-block">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
        @endif
    </div>
    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
        <label class="control-label visible-ie8 visible-ie9">Mã sinh viên</label>
        <div class="input-icon">
            <i class="fa fa-user"></i>
            <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Tên đăng nhập" name="name">
        </div>
        @if ($errors->has('name'))
            <span class="help-block">
                <strong>{{ $errors->first('name') }}</strong>
            </span>
        @endif
    </div>
    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
        <label class="control-label visible-ie8 visible-ie9">Mật khẩu</label>
        <div class="input-icon">
            <i class="fa fa-lock"></i>
            <input class="form-control placeholder-no-fix" type="password" autocomplete="off" id="register_password" placeholder="Mật khẩu" name="password">
        </div>
        @if ($errors->has('password'))
            <span class="help-block">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
        @endif
    </div>
    <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
        <label class="control-label visible-ie8 visible-ie9">Nhập lại mật khẩu</label>
        <div class="controls">
            <div class="input-icon">
                <i class="fa fa-check"></i>
                <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Nhập lại mật khẩu" name="password_confirmation">
            </div>
            @if ($errors->has('password_confirmation'))
                <span class="help-block">
                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="form-group">
        <label class="mt-checkbox mt-checkbox-outline">
            <input type="checkbox" name="tnc"> Đồng ý với
            <a href="javascript:;">điều khoản của chúng tôi </a>
            <span></span>
        </label>
        <div id="register_tnc_error"> </div>
    </div>
    <div class="form-actions">
        <button type="submit" id="register-submit-btn" class="btn green pull-right"> Đăng ký </button>
    </div>
    <div class="forget-password">
        <p> 
            <a href="{{ url('/login') }}" id="forget-password">Trở về trang đăng nhập</a>
        </p>
    </div>
</form>
@endsection
