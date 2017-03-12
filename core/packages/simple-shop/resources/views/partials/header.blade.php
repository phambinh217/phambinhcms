<div class="ui menu fixed top">
    <div class="header item">
        <a href="{{ url('/') }}">{{ setting('company-name') }}</a>
    </div>
    <div class="item">
        <form action="{{ route('search') }}" class="ui transparent icon input">
            <input name="_keyword" type="text" placeholder="Tên sản phẩm...">
            <button class="ui button">Tìm kiếm</button>
        </form>
    </div>
    <div class="right menu">
        <a class="cart item" href="{{ route('cart.index') }}">
            <i class="cart icon"></i>
            Giỏ hàng <span class="ui {{ \Cart::count() > 0 ? 'red' : '' }} circular label cart-count">{{ \Cart::count() }}</span>
        </a>
        <div class="ui popup flowing">
            <div class="ui" id="cart-content" style="">
                @include('Home::partials.cart-quickview')
            </div>
        </div>
        <a class="compare item" href="{{ route('compare.index') }}">
            <i class="zoom icon"></i>
            Giỏ so sánh <span class="ui {{ \Compare::count() > 0 ? 'red' : '' }} circular label compare-count">{{ \Compare::count() }}</span>
        </a>
        @if(! \Auth::check())
            <div class="item">
                <button class="ui primary button register-btn">Đăng ký</button>
            </div>
            <div class="item">
                <button class="ui button login-btn">Đăng nhập</button>
            </div>
        @else
            <a class="item" href="{{ route('mail.index') }}">
                <i class="mail icon"></i>
                @php $count_mail = \Auth::user()->inbox()->applyFilter(['check' => FALSE])->count(); @endphp
                Hộp thư <span class="ui {{ $count_mail > 0 ? 'red' : '' }} circular label">{{ $count_mail }}</span>
            </a>
            <a class="popup profile item" data-content="Vào trang cá nhân" href="{{ route('profile.index') }}">
                <img class="ui avatar image" src="{{ thumbnail_url(\Auth::user()->avatar, ['width' => '32', 'height' => '32']) }}">
                <span>{{ \Auth::user()->full_name }}</span>
            </a>
            <div class="item">
                <button class="ui button negative icon logout-btn">
                    <i class="sign out icon"></i> Đăng xuất
                </button>
            </div>
        @endif
    </div>
</div>
<div style="padding: 40px"></div>

<div class="ui container">
    @include('Home::partials.nav')
</div>
<div style="padding: 10px"></div>

@push('html_footer')
    @if(!\Auth::check())
        <div class="ui modal small" id="login-modal">
            <i class="close icon"></i>
            <div class="header">Đăng nhập</div>
            <div class="content">
                <form  class="ui form" action="{{ url('/login') }}" method="post" id="login-form">
                    {{ csrf_field() }}
                    <div class="field">
                        <label>Địa chỉ email</label>
                        <input type="text" name="email" placeholder="Email">
                    </div>
                    <div class="field">
                        <label>Mật khẩu</label>
                        <input type="password" name="password" placeholder="Mật khẩu">
                    </div>
                    <div class="field">
                        <input type="checkbox" name="remember" />
                        <label>Nhớ tài khoản</label>
                    </div>
                    <button class="ui primary button" type="submit">Đăng nhập</button>
                    <a href="{{ route('customer.register') }}" class="ui primary button positive">Tạo tài khoản</a>
                    <a href="{{ route('customer.reset-password') }}">Quên mật khẩu</a>
                </form>
            </div>
        </div>
        <div class="ui modal small" id="register-modal">
            <i class="close icon"></i>
            <div class="header">Đăng ký</div>
            <div class="content">
                <form class="ui form" action="{{ url('/') }}" method="post">
                    {{ csrf_field() }}
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
                    <button class="ui primary button" type="submit">Đăng ký</button>
                </form>
            </div>
        </div>
    @else
        <form id="logout-form" action="{{ url('logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
        </form>
    @endif
@endpush

@push('js_footer')
    @if(!\Auth::check())
        <script type="text/javascript">
            $(function(){
                $('.login-btn').click(function(){
                    $('#login-modal').modal('show');
                });
                handleAjaxForm('#login-form');

                $('.register-btn').click(function(){
                    $('#register-modal').modal('show');
                });
            });
        </script>
    @else
        <script type="text/javascript">
            $(function(){
                $('.popup.profile').popup();
                $('.logout-btn').click(function(e){
                    e.preventDefault();
                    $('#logout-form').submit();
                });
            });
        </script>
    @endif
    <script type="text/javascript">
        $(function(){
            $('.cart').popup({
                inline     : false,
                hoverable  : true,
                delay: {
                    show: 300,
                    hide: 800
                }
            });
        });
    </script>
@endpush