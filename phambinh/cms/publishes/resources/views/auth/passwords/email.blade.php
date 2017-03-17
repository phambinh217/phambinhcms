@extends('Cms::layouts.auth')

<!-- Main Content -->
@section('content')
    <form class="forget-form" action="{{ url('/password/email') }}" method="post" novalidate="novalidate" style="display: block;">
        <h3>Quên mật khẩu ?</h3>
        <p> Nhập địa chỉ email của bạn để reset mật khẩu. </p>
        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            <div class="input-icon">
                <i class="fa fa-envelope"></i>
                <input value="{{ old('email') }}" class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Địa chỉ email" name="email">
                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn green pull-right"> Gửi </button>
        </div>
        <div class="forget-password">
            <p> 
                <a href="{{ url('/login') }}" id="forget-password">Trở về trang đăng nhập</a>
            </p>
        </div>
    </form>
@endsection
