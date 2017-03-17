@extends('layouts.install')

@section('main')
	<div class="row">
		<div class="col-sm-offset-2 col-sm-9">
			<div class="panel panel-default">
				<div class="panel-heading"><h3>Cài đặt thành công</h3></div>
				<div class="panel-body">
					<p>Cms đã được cài đặt thành công. Cám ơn bạn đã sử dụng cms!</p>
					<div class="row">
						<div class="col-sm-6">
							<table class="table table-bordered table-hover">
								<tr>
									<td><strong>Email</strong></td>
									<td>{{ $email }}</td>
								</tr>
								<tr>
									<td><strong>Mật khẩu</strong></td>
									<td><i>Mật khẩu của bạn</i></td>
								</tr>
							</table>
						</div>
					</div>
					<p>Đừng quên xóa đi thư mục <code>install</code> để hệ thống an toàn hơn. Sau đó bạn có thể đăng nhập vào trang quản trị.</p>
					<a href="{{ url('install.remove-install-and-login') }}" class="btn btn-default" />Xóa thư mục cài đặt và đăng nhập</a>
				</div>
			</div>
		</div>
	</div>
@endsection