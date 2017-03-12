<div class="modal fade" id="popup-forward">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Chuyển tiếp thư</h4>
			</div>
			<div class="modal-body">
				<form method="post" action="{{ admin_url('mail') }}" class="form-horizontal form-bordered form-row-stripped ajax-form">
			        {{ csrf_field() }}
			        <div class="form-body">
			            <div class="form-group">
			                <label class="control-label col-md-2">
			                    Người nhận <span class="required">*</span>
			                </label>
			                <div class="col-md-10">
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
			                <div class="col-md-10">
			                    <input value="{{ $mail->subject or '' }}" name="mail[subject]" type="text" class="form-control" />
			                </div>
			            </div>
			            <div class="form-group">
			                <label class="control-label col-md-2">
			                    Nội dung <span class="required">*</span>
			                </label>
			                <div class="col-md-10">
			                    <textarea style="min-height: 200px" class="form-control" name="mail[content]">{{ $mail->content or '' }}</textarea>
			                </div>
			            </div>
			            
			            <div class="form-group">
			                <label class="control-label col-md-2"></label>
			                <div class="col-md-10">
			                    <button type="submit" class="btn btn-primary" name="save_only">
			                        <i class="fa fa-paper-plane"></i> Chuyển tiếp
			                    </button>
			                </div>
			            </div>
			        </div>
			    </form>
			</div>
		</div>
	</div>
</div>