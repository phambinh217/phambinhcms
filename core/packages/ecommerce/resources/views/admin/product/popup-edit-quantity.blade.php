<div class="modal fade" id="popup-edit-quantity">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">{{ $product->name }}</h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" method="post" action="{{ route('admin.ecommerce.product.update-quantity', ['id' => $product->id]) }}">
					{{ csrf_field() }}
					{{ method_field('PUT') }}
					<div class="form-group">
						<label class="control-label col-sm-3">Số lượng</label>
						<div class="col-sm-7">
							<input type="text" name="product[quantity]" class="form-control" value="{{ $product->quantity }}" />
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-3">Trừ trong kho</label>
						<div class="col-sm-7">
							@include('Ecommerce::admin.components.form-select-subtract', [
								'subtract' => $product->getSubtractAble(),
								'name' => 'product[subtract]',
								'class' => 'width-auto',
								'selected' => $product->subtract ? 'true' : 'false',
							])
						</div>
					</div>
					<div class="text-right">
						<button class="btn btn-primary" type="submit">Lưu</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>