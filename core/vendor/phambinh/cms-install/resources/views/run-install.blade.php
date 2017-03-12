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
        	<div id="before-install">
	        	<p>Hệ thống đã tiếp nhận tất cả các thông tin của bạn, giờ là lúc để bắt đầu...</p>
	        	<div id="progress-bar" class="progress progress-striped active">
					<div class="progress-bar progress-bar-success" role="progressbar" style="width: 0%">
					</div>
				</div>
	            <button id="run-install" class="btn btn-primary full-width-xs">Cài đặt</button>
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
            	<a href="{{ url('/login') }}" class="btn btn-primary" /><i class="fa fa-sign-in"></i> Đăng nhập</a>
            </div>
        </div>
    </div>
@endsection

@push('css')
	<link href="{{ asset_url('admin', 'global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
@endpush

@push('js_footer')
	<script type="text/javascript" src="{{ asset_url('admin', 'global/plugins/jquery-form/jquery.form.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset_url('admin', 'global/plugins/bootstrap-toastr/toastr.min.js') }}"></script>
	<script type="text/javascript">
		$(function () {
			$('#run-install').click(function(e){
				e.preventDefault();
				var button = $(this);
				var progressBar = $('#progress-bar');
				progressBar.show();
				$.ajax({
					url: '{{ route('install.installing') }}',
					type: 'post',
					dataType: 'json',
					data: {
						_token: '{{ csrf_token() }}',
					},
					success: function (res) {
						setTimeout(function(){
							progressBar.find('div[role="progressbar"]').css('width', '100%');
						}, 100);

						$('#before-install').hide();
						$('#after-install').show();
					}
				});
			});
		});
	</script>
@endpush