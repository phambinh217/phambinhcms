@extends('Cms::layouts.default',[
	'active_admin_menu' 	=> [' ecommerce.product', isset($product_id) ? ' ecommerce.product.index' : ' ecommerce.product.create'],
	'breadcrumbs' 			=> [
		'title'	=> ['Sản phẩm', isset($product_id) ? trans('cms.edit') : trans('cms.add-new')],
		'url'	=> [route('admin.ecommerce.product.index')],
	],
])

@section('page_title', isset($product_id) ? 'Chỉnh sửa sản phẩm' : 'Thêm sản phẩm mới')

@if(isset($product_id))
	@section('page_sub_title', $product->name)
	@section('tool_bar')
		<a href="{{ route('admin.ecommerce.product.create') }}" class="btn btn-primary">
			<i class="fa fa-plus"></i> <span class="hidden-xs">Thêm sản phẩm mới</span>
		</a>
	@endsection
@endif

@section('content')
	<form class="ajax-form" action="{{ isset($product_id) ? route('admin.ecommerce.product.update', ['id' => $product_id]) : route('admin.ecommerce.product.store') }}" method="post">
		{{ csrf_field() }}
		@if(isset($product_id))
			{{ method_field('PUT') }}
		@endif
		<div class="portlet light bordered form-fit">
			<div class="portlet-title with-tab">
				<div class="tab-default">
					<ul class="nav nav-tabs">
						<li class="active">
							<a href="#product-base" data-toggle="tab" aria-expanded="true"> Sản phẩm </a>
						</li>
						<li class="">
							<a href="#product-data" data-toggle="tab" aria-expanded="false"> Dữ liệu </a>
						</li>
						<li class="">
							<a href="#product-link" data-toggle="tab" aria-expanded="false"> Liên kết </a>
						</li>
						<li class="">
							<a href="#product-option" data-toggle="tab" aria-expanded="false"> Tùy chọn </a>
						</li>
						<li class="">
							<a href="#product-attribute" data-toggle="tab" aria-expanded="false"> Thuộc tính </a>
						</li>
						<li class="">
							<a href="#product-image" data-toggle="tab" aria-expanded="false"> Hình ảnh </a>
						</li>
						<li class="">
							<a href="#product-seo" data-toggle="tab" aria-expanded="false"> SEO </a>
						</li>
					</ul>
				</div>
			</div>
			<div class="portlet-body form">
				<div class="tab-content">
					<div class="tab-pane active" id="product-base">
						<div class="form-horizontal form-bordered">
							<div class="form-body">
								<div class="form-group">
									<label class="control-label col-sm-2">Tên sản phẩm</label>
									<div class="col-sm-10">
										<div class="row">
											<div class="col-sm-6">
												<input type="text" name="product[name]" value="{{ $product->name }}" class="form-control" />
											</div>
											<div class="col-sm-6">
												<input type="text" name="product[slug]" value="{{ $product->slug }}" placeholder="Slug" class="form-control str-slug" value="{{ $product->slug or '' }}" />
												<label class="checkbox-inline">
													<input type="checkbox" value="true" checked="" id="create-slug">
													Từ tên sản phẩm
												</label>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-2">Nội dung</label>
									<div class="col-sm-10">
										{!! Form::tinymce('product[content]', $product->content) !!}
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">Thẻ</label>
									<div class="col-sm-10">
										@include('Ecommerce::admin.components.form-input-tags', [
											'name' => 'tag_id[]',
											'tags' => isset($product_id) ? $product->tags : [],
											'create' => true,
										])
									</div>
								</div>
								<div class="form-group media-box-group">
	                                <label class="control-label col-md-2">Ảnh đại diện</label>
	                                <div class="col-sm-10">
	                                    {!! Form::btnMediaBox('product[thumbnail]', $product->thumbnail, thumbnail_url($product->thumbnail, ['width' => '100', 'height' => '100'])) !!}
	                                </div>
	                            </div>
                            </div>
                        </div>
					</div>
					
					<div class="tab-pane" id="product-data">
						<div class="form-horizontal form-bordered">
							<div class="form-body">
								<div class="form-group">
									<label class="col-sm-2 control-label"price">Giá</label>
									<div class="col-sm-3">
										<input type="text" name="product[price]" value="{{ $product->price or '' }}" placeholder="Giá" class="form-control">
										<label class="checkbox-inline">
											<input name="is_sale" type="checkbox" value="true" {{ isset($product_id) && $product->isSale() ? 'checked' : '' }} id="product-is-sale" />
											Sản phẩm có giảm giá        
										</label>
									</div>
								</div>
								<div class="form-group promotional_price" {!! isset($product_id) && $product->isSale() ? '' : 'style="display: none"' !!}>
									<label class="col-sm-2 control-label">Giá khuyễn mại</label>
									<div class="col-sm-3">
										<input type="text" name="product[promotional_price]" value="{{ $product->promotional_price or '' }}" placeholder="Giá khuyễn mại" class="form-control">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">
										Trừ trong kho
									</label>
									<div class="col-sm-10">
										@include('Ecommerce::admin.components.form-select-subtract', [
											'subtract' => $product->getSubtractAble(),
											'name' => 'product[subtract]',
											'class' => 'width-auto',
											'attributes' => 'id="product-subtract"',
											'selected' => isset($product_id) && $product->isSubtract() ? 'true' : 'false',
										])
									</div>
								</div>
								<div class="form-group quantity" {!! isset($product_id) && $product->isSubtract() ? '' : 'style="display: none"' !!}>
									<label class="col-sm-2 control-label">Số lượng</label>
									<div class="col-sm-3">
										<input type="text" name="product[quantity]" value="{{ $product->quantity }}" placeholder="Số lượng" class="form-control">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="input-date-available">Ngày có sẵn</label>
									<div class="col-sm-3">
										<div class="input-group date">
											<input type="text" name="product[available_at]" value="{{ isset($product_id) ? changeFormatDate($product->available_at, DF_DB, DF_NORMAL) : date(DF_NORMAL) }}" class="form-control" />
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="input-status">Trạng thái</label>
									<div class="col-sm-10">
										@include('Ecommerce::admin.components.form-select-product-status', [
	                                		'statuses' => $product->statusable()->all(),
	                                		'class' => 'width-auto',
	                                		'name' => 'product[status]',
	                                		'selected' => isset($product_id) && $product->isEnable() ? 'enable' : 'disable',
	                                	])
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="tab-pane" id="product-link">
						<div class="form-horizontal form-bordered">
							<div class="form-body">
								<div class="form-group">
									<label class="col-sm-2 control-label">Danh mục</label>
									<div class="col-sm-3">
										@include('Ecommerce::admin.components.form-checkbox-product', [
											'header' => true,
	                                		'categories' => \Packages\Ecommerce\Category::select('id', 'name', 'parent_id')->get(),
	                                		'name' => 'product_id[]',
	                                		'checked' => $product->categories->pluck('id')->all(),
	                                	])
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">Thương hiệu</label>
									<div class="col-sm-3">
										@include('Ecommerce::admin.components.form-checkbox-brand', [
											'header' => true,
	                                		'brands' => \Packages\Ecommerce\Brand::select('id', 'name', 'parent_id')->get(),
	                                		'name' => 'brand_id[]',
	                                		'checked' => $product->brands->pluck('id')->all(),
	                                	])
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">Bộ lọc</label>
									<div class="col-sm-3">
										@include('Ecommerce::admin.components.form-checkbox-filter', [
											'header' => true,
	                                		'filters' => \Packages\Ecommerce\Filter::select('id', 'name', 'parent_id')->get(),
	                                		'name' => 'filter_id[]',
	                                		'checked' => $product->filters->pluck('id')->all(),
	                                	])
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<div class="tab-pane" id="product-option" style="padding: 15px">
						@include('Ecommerce::admin.components.product.tab-option', [
							'options' => Packages\Ecommerce\Option::select('id', 'name', 'type')->get(),
							'values'  => \Packages\Ecommerce\OptionValue::get(),
							'product_options' => $product->options,
							'product_option_values' => $product->optionValues()->get(),
							'product' => $product,
						])
					</div>

					<div class="tab-pane" id="product-attribute" style="padding: 15px">
						@include('Ecommerce::admin.components.product.tab-attribute', [
							'attributes' => Packages\Ecommerce\Attribute::select('id', 'name')->get(),
							'product_attributes' => $product->attributes->sortBy('pivot.order')->values(),
							'product' => $product,
						])
					</div>

					<div class="tab-pane" id="product-image" style="padding: 15px">
						@include('Ecommerce::admin.components.product.tab-image', [
							'product' => $product,
							'product_images' => $product->images,
						])
					</div>
					
					<div class="tab-pane" id="product-seo">
						<div class="form-horizontal form-bordered">
							<div class="form-body">
								<div class="form-group required">
									<label class="col-sm-2 control-label">trans('cms.meta-title')</label>
									<div class="col-sm-10">
										<input type="text" name="product[meta_title]" value="{{ $product->meta_title }}" placeholder="trans('cms.meta-title')" class="form-control">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">trans('cms.meta-description')</label>
									<div class="col-sm-10">
										<textarea name="product[meta_description]" rows="5" placeholder="trans('cms.meta-description')" class="form-control">{{ $product->meta_description or '' }}</textarea>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">Meta deywords</label>
									<div class="col-sm-10">
										<textarea name="product[meta_keyword]" rows="5" placeholder="trans('cms.meta-keyword')s" class="form-control">{{ $product->meta_keyword }}</textarea>
									</div>
								</div>
                            </div>
                        </div>
					</div>

				</div>
				<div class="form-bordered">
					<div class="form-actions util-btn-margin-bottom-5">
						<div class="row">
							<div class="col-md-offset-3 col-md-9">
								@if(!isset($product_id))
									{!! Form::btnSaveNew() !!}
								@else
									{!! Form::btnSaveOut() !!}
								@endif
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
@endsection

@push('css')
    <link href="{{ asset_url('admin', 'global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset_url('admin', 'global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push('js_footer')	
    <script type="text/javascript" src="{{ asset_url('admin', 'global/plugins/jquery-form/jquery.form.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset_url('admin', 'global/plugins/bootstrap-toastr/toastr.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset_url('admin', 'global/plugins/tinymce/tinymce.min.js')}} "></script>
    <script type="text/javascript" src="{{ asset_url('admin', 'global/plugins/vuejs/js/vue.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset_url('admin', 'global/plugins/vue-resource/vue-resource.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset_url('admin', 'global/plugins/vue-sortable/sortable.js') }}"></script>
    <script type="text/javascript" src="{{ asset_url('admin', 'global/plugins/vue-sortable/vue-sortable.js') }}"></script>
    <script type="text/javascript">
    	$(function(){
    		$('#product-is-sale').click(function(){
    			if (this.checked) {
    				$('.promotional_price').show();
    			} else {
    				$('.promotional_price').hide();
    			}
    		});

    		$('#product-subtract').change(function() {
    			if ($(this).val() == 'true') {
    				$('.quantity').show();
    			} else {
    				$('.quantity').hide();
    			}
    		});

    		$('#create-slug').click(function() {
    			if(this.checked) {
    				var title = $('input[name="product[name]"]').val();
    				var slug = strSlug(title);
    				$('input[name="product[slug]"]').val(slug);
    			}
    		});

    		$('input[name="product[name]"]').keyup(function() {
    			if ($('#create-slug').is(':checked')) {
    				var title = $(this).val();
    				var slug = strSlug(title);
    				$('input[name="product[slug]"]').val(slug);	
    			}
    		});
    	});
    </script>
@endpush