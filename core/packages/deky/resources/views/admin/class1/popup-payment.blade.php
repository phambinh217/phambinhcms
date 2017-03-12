<div class="modal fade" id="popup-payment">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">{{ $student->full_name }} đóng học phí</h4>
			</div>
			<div class="modal-body">
				<div role="tabpanel">
					<ul class="nav nav-tabs" role="tablist">
						<li role="presentation" class="active">
							<a href="#payment" aria-controls="payment" role="tab" data-toggle="tab">
								<i class="fa fa-sign-out"></i> Thanh toán
							</a>
						</li>
						<li role="presentation">
							<a href="#payment-history" aria-controls="tab" role="tab" data-toggle="tab">
								<i class="fa fa-history"></i> Lịch sử thanh toán
							</a>
						</li>
					</ul>

					<div class="tab-content">
						<div role="tabpanel" class="tab-pane active" id="payment">
							<div class="note note-success">
						        <p>
						        	<i class="fa fa-info"></i> Đã nộp <code>{{ $history->sum('value') }} VND</code> trong <code>{{ $history->count() }}</code> lần. Số tiền phải nộp <code>{{ $class->value_require }} VND</code>
						        </p>
						    </div>
							<form action="{{ route('admin.class.payment-store', ['class' => $class->id]) }}" method="POST" class="form-horizontal" role="form" id="form-payment">
								{{ csrf_field() }}
								<div class="form-group">
									<label class="col-sm-3 control-label">Nộp thêm</label>
									<div class="col-sm-9">
										<input name="payment[value]" type="text" name="" class="form-control" />
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label">Ghi chú</label>
									<div class="col-sm-9">
										<textarea name="payment[comment]" class="form-control"></textarea>
									</div>
								</div>
								<div class="text-right">
									<button class="btn btn-primary full-width-xs">
										<i class="fa fa-sign-out"></i> Nộp thêm
									</button>
								</div>
							</form>	
						</div>
						<div role="tabpanel" class="tab-pane" id="payment-history">
							<table class="table table-hover table-bordered table-striped">
								<thead>
									<tr>
										<th class="text-center">
											STT
										</th>
										<th class="text-center bg-primary">
											Số tiền
										</th>
										<th>Ngày</th>
										<th>Người thu</th>
										<th>Ghi chú</th>
									</tr>
								</thead>
								<tbody>
									@foreach($history as $history_item)
										<tr>
											<td class="text-center">
												{{ $loop->index + 1 }}
											</td>
											<td class="text-center bg-primary">
												<strong>{{ $history_item->value }}</strong>
											</td>
											<td>{{ text_time_difference($history_item->created_at) }}</td>
											<td>{{ Packages\Cms\User::select('id', 'first_name', 'last_name')->find($history_item->collecter_id)->full_name }}</td>
											<td>{{ $history_item->comment }}</td>
										</tr>
									@endforeach
									<tr>
										<td></td>
										<td class="text-center bg-primary">Tổng: {{ $history->sum('value') }} VND</td>
										<td></td>
										<td></td>
										<td></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		$(function(){
			$('#form-payment').handleAjaxForm({
				success: function() {
					$('#popup-payment').modal('hide');
				},
			});
		});
	</script>
</div>