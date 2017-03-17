@extends('Install::layouts.install')

@section('content')
	<div class="portlet light bordered form-fit">
        <div class="portlet-title">
            <div class="caption">
                <i class="icon-equalizer"></i>
                <span class="caption-subject bold uppercase">Thông tin website</span>
            </div>
        </div>
        <div class="portlet-body form">
            <!-- BEGIN FORM-->
            <form action="{{ route('install.check-site-info') }}" method="post" accept-charset="utf-8" class="form-horizontal form-bordered">
                <div class="form-body">
                    {{ csrf_field() }}
					<div class="form-group {{ $errors->has('company_name') ? 'has-error' : '' }}">
						<label for="" class="col-sm-3 control-label">Tiêu đề trang</label>
						<div class="col-sm-9">
							<input name="company_name" type="text" class="form-control input-sm" value="{{ old('company_name') }}" />
							<p class="help-block">Tên webstite hoặc tên doanh nghiệp của bạn.</p>
							@if($errors->has('company_name'))
								<p class="text-danger">{{ $errors->first('company_name') }}</p>
							@endif
						</div>
					</div>
					<div class="form-group {{ $errors->has('username') ? 'has-error' : '' }}">
						<label for="" class="col-sm-3 control-label">Tên tài khoản</label>
						<div class="col-sm-9">
							<input name="username" type="text" class="form-control input-sm" value="{{ old('username') }}" />
							<p class="help-block">Tên tài khoản dành cho người quản trị.</p>
							@if($errors->has('username'))
								<p class="text-danger">{{ $errors->first('username') }}</p>
							@endif
						</div>
					</div>
					<div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
						<label for="" class="col-sm-3 control-label">Email</label>
						<div class="col-sm-9">
							<input name="email" type="text" class="form-control input-sm" value="{{ old('email') }}" />
							<p class="help-block">Địa chỉ email dùng để đăng nhập cho người quản trị.</p>
							@if($errors->has('email'))
								<p class="text-danger">{{ $errors->first('email') }}</p>
							@endif
						</div>
					</div>
					<div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
						<label for="" class="col-sm-3 control-label">Mật khẩu</label>
						<div class="col-sm-9">
							<input name="password" type="password" class="form-control input-sm" value="{{ old('password') }}" />
							<p class="help-block">Mật khẩu cho người quản trị</p>
							@if($errors->has('password'))
								<p class="text-danger">{{ $errors->first('password') }}</p>
							@endif
						</div>
					</div>
					<div class="form-group {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
						<label for="" class="col-sm-3 control-label">Nhập lại mật khẩu</label>
						<div class="col-sm-9">
							<input name="password_confirmation" type="password" class="form-control input-sm" value="{{ old('password_confirmation') }}" />
							<p class="help-block">Nhập lại mật khẩu bên trên.</p>
							@if($errors->has('password_confirmation'))
								<p class="text-danger">{{ $errors->first('password_confirmation') }}</p>
							@endif
						</div>
					</div>
                </div>

                <div class="form-actions util-btn-margin-bottom-5">
                	<div class="row">
                		<div class="col-md-offset-3 col-md-9">
                			<button class="btn btn-primary full-width-xs">Bước tiếp theo</button>
                		</div>
                	</div>
                </div>
            </form>
            <!-- END FORM-->
        </div>
    </div>
@endsection