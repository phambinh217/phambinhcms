@extends('Install::layouts.install')

@section('content')
	<div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <i class="icon-equalizer"></i>
                <span class="caption-subject bold uppercase">Chạy cài đặt</span>
            </div>
        </div>
        <div class="portlet-body">
        	<form action="{{ route('install.installing') }}" class="mb-10" method="post" id="before-install">
        		{{ csrf_field() }}
	        	<p>Hệ thống đã tiếp nhận tất cả các thông tin của bạn, giờ là lúc để bắt đầu...</p>
	            <button id="run-install" class="btn btn-primary full-width-xs">Cài đặt</button>
            </form>
            <div id="progress-bar" class="progress progress-striped active">
				<div class="progress-bar progress-bar-success" role="progressbar" style="width: 0%">
				</div>
			</div>
            <div id="after-install"  style="display: none">
            	<p>Cms đã được cài đặt thành công. Cám ơn bạn đã sử dụng cms!.<br />
            	Giờ bạn có thể truy cập vào trang đăng nhập bằng thông tin phía dưới.</p>
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
            	<a href="{{ url('/login') }}" class="btn btn-primary full-width-xs" /><i class="fa fa-sign-in"></i> Đăng nhập</a>
            </div>
        </div>
    </div>
@endsection

@addCss('css', asset_url('admin', 'global/plugins/bootstrap-toastr/toastr.min.css'))
@addJs('js_footer', asset_url('admin', 'global/plugins/jquery-form/jquery.form.min.js'))
@addJs('js_footer', asset_url('admin', 'global/plugins/bootstrap-toastr/toastr.min.js'))

@push('js_footer')
	<script type="text/javascript">
		$(function () {
			var progressBar = $('#progress-bar');
			$('#before-install').ajaxForm({
				dataType: 'json',
				uploadProgress: function(event, position, total, percentComplete) {
					var percentValue = percentComplete + '%';
					progressBar.find('div[role="progressbar"]').css('width', '100%');
				},

				success: function(result) {
					var percentValue = '100%';
					progressBar.find('div[role="progressbar"]').css('width', '100%');
					$('#before-install').hide();
					$('#after-install').show();
				},
			});
		});
	</script>
@endpush

