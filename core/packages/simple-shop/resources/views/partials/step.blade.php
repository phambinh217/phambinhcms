<div class="ui {{ $type or '' }} steps">
	<div class="{{ isset($active) && $active == 1 ? 'active' : '' }} step">
		<i class="truck icon"></i>
		<div class="content">
			<div class="title">Chọn sản phẩm</div>
			<div class="description">Choose your shipping options</div>
		</div>
	</div>
	<div class="{{ isset($active) && $active == 2 ? 'active' : '' }} step">
		<i class="credit card icon"></i>
		<div class="content">
			<div class="title">Kiểm tra giỏ hàng</div>
			<div class="description">Enter billing information</div>
		</div>
	</div>
	<div class="{{ isset($active) && $active == 3 ? 'active' : '' }} step">
		<i class="info icon"></i>
		<div class="content">
			<div class="title">Thanh toán</div>
			<div class="description">Verify order details</div>
		</div>
	</div>
</div>