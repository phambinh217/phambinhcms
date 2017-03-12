@extends('Cms::layouts.default',[
	'active_admin_menu' 	=> ['mail', 'mail.create'],
	'breadcrumbs' 			=> [
		'title'	=> ['Hộp thư', 'Soạn thư mới'],
		'url'	=> [
			admin_url('mail'),
		],
	],
])

@section('page_title', 'Soạn thư mới')

@section('content')
	<form method="post" action="{{ admin_url('mail') }}" class="form-horizontal form-bordered form-row-stripped ajax-form">
        {{ csrf_field() }}
        <div class="form-body">
            <div class="form-group">
                <label class="control-label col-md-2">
                    Người nhận <span class="required">*</span>
                </label>
                <div class="col-md-6">
                    <select name="mail[receiver_id]" id="select2-button-addons-single-input-group-sm" class="form-control find-user">
                        <option value="0">-- Tìm kiếm --</option>
                        @if(! empty($filter['receiver_id']))
                            <option selected="" value="{{ $filter['receiver_id'] }}">{{ Packages\Cms\User::select('first_name', 'last_name')->find($filter['receiver_id'])->full_name }}</option>
                        @endif
                    </select>
                    <span class="help-block">
                        Nhập <code>ID</code>, hoặc <code>Email</code> hoặc <code>Số điện thoại</code> để tìm kiếm<br />
                    </span>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-2">
                    Chủ đề <span class="required">*</span>
                </label>
                <div class="col-md-6">
                    <input value="{{ $filter['subject'] or '' }}" name="mail[subject]" type="text" class="form-control" />
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-2">
                    Nội dung <span class="required">*</span>
                </label>
                <div class="col-md-10">
                    <textarea style="min-height: 200px" class="form-control" name="mail[content]"></textarea>
                </div>
            </div>
            
            <div class="form-group">
                <label class="control-label col-md-2"></label>
                <div class="col-md-10">
                    <button type="submit" class="btn btn-primary" name="save_only">
                        <i class="fa fa-paper-plane"></i> Gửi và thoát
                    </button>
                    <button type="submit" class="btn btn-primary" name="save_and_new">
                        <i class="fa fa-paper-plane"></i> Gửi và tiếp tục gửi
                    </button>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('css')
    <link href="{{ asset_url('admin', 'global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
@endpush

@push('js_footer')
    <script type="text/javascript" src="{{ asset_url('admin', 'global/plugins/jquery-form/jquery.form.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset_url('admin', 'global/plugins/bootstrap-toastr/toastr.min.js') }}"></script>
    <script type="text/javascript">
@endpush


@include('Cms::component.find-user')