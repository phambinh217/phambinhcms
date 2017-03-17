@extends('Install::layouts.install')
@section('content')
    @if($errors->has('message'))
        <div class="alert alert-danger">Không thể kết nối đến cơ sở dữ liệu với thông tin bên dưới. Hãy kiểm tra lại thông tin.</div>
    @else
        <div class="alert alert-info"><i class="fa fa-info"></i> Bước này chỉ cấu hình kết nối đến database chứ không trực tiếp tạo cơ sở dữ liệu.</div>
    @endif
	<div class="portlet light bordered form-fit">
        <div class="portlet-title">
            <div class="caption">
                <i class="icon-equalizer"></i>
                <span class="caption-subject bold uppercase">Kết nối cở sở dữ liệu</span>
            </div>
        </div>
        <div class="portlet-body form">
            <!-- BEGIN FORM-->
            <form action="{{ route('install.check-connect') }}" method="post" accept-charset="utf-8" class="form-horizontal form-bordered">
                <div class="form-body">
                    {{ csrf_field() }}
                    <div class="form-group {{ $errors->has('db.name') ? 'has-error' : '' }}">
                        <label for="" class="col-sm-3 control-label">Tên cơ sở dữ liệu</label>
                        <div class="col-sm-9">
                            <input name="db[name]" type="text" class="form-control input-sm" value="{{ old('db.name') }}" />
                            <span class="help-block">
                                Tên của cơ sở dữ liệu. (Bạn phải tạo cơ sở dữ liệu từ trước).
                            </span>
                            @if($errors->has('db.name'))
                            	<p class="text-danger">{{ $errors->first('db.name') }}</p>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('db.username') ? 'has-error' : '' }}">
                        <label for="" class="col-sm-3 control-label">Tên đăng nhập</label>
                        <div class="col-sm-9">
                            <input name="db[username]" type="text" class="form-control input-sm" value="{{ old('db.username') }}" />
                            <span class="help-block">Tên đăng nhập vào cơ sở dữ liệu.</span>
                            @if($errors->has('db.username'))
                            	<p class="text-danger">{{ $errors->first('db.username') }}</p>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('db.password') ? 'has-error' : '' }}">
                        <label for="" class="col-sm-3 control-label">Mật khẩu</label>
                        <div class="col-sm-9">
                            <input name="db[password]" type="text" class="form-control input-sm" value="{{ old('db.password') }}" />
                            <span class="help-block">Mật khẩu của cơ sở dữ liệu.</span>
                            @if($errors->has('db.password'))
                            	<p class="text-danger">{{ $errors->first('db.password') }}</p>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('db.localhost') ? 'has-error' : '' }}">
                        <label for="" class="col-sm-3 control-label">Địa chỉ máy chủ cơ sở dữ liệu</label>
                        <div class="col-sm-9">
                            <input name="db[localhost]" type="text" class="form-control input-sm" value="{{ old('db.localhost', 'localhost') }}" />
                            <span class="help-block">Nếu <code>localhost</code> không được, hãy thử liên hệ với nhà cung cấp hosting của bạn để lấy thông tin này.</span>
                            @if($errors->has('db.localhost'))
                            	<p class="text-danger">{{ $errors->first('db.localhost') }}</p>
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