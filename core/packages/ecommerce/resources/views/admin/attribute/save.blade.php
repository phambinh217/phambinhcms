@extends('Cms::layouts.default',[
	'active_admin_menu'	=> [ 'ecommerce', ' ecommerce.attribute', isset($attribute_id) ? ' ecommerce.attribute.index' : ' ecommerce.attribute.create'],
	'breadcrumbs' 			=> [
		'title'	=> ['Thuộc tính', isset($attribute_id) ? trans('cms.add-new') : trans('cms.edit')],
		'url'	=> [
			route('admin.ecommerce.attribute.index')
		],
	],
])

@section('page_title', isset($attribute_id) ? 'Chỉnh sửa thuộc tính' : 'Thêm thuộc tính mới')

@if(isset($attribute_id))
	@section('page_sub_title', $attribute->name)
	@section('tool_bar')
		<a href="{{ route('admin.ecommerce.attribute.create') }}" class="btn btn-primary">
			<i class="fa fa-plus"></i> <span class="hidden-xs">Thêm thuộc tính mới</span>
		</a>
	@endsection
@endif

@section('content')
	<form action="{{ isset($attribute_id) ? route('admin.ecommerce.attribute.update', ['id' => $attribute->id])  : route('admin.ecommerce.attribute.store') }}" method="post" class="form-horizontal form-bordered form-row-stripped ajax-form">
		@if(isset($attribute_id))
			{{ method_field('PUT') }}
		@endif
		{{ csrf_field() }}
		<div class="form-body">
			<div class="form-group">
				<label class="control-label col-sm-3 pull-left">
					Tên thuộc tính <span class="required">*</span>
				</label>
				<div class="col-sm-7">
					<input value="{{ $attribute->name }}" name="attribute[name]" type="text" placeholder="" class="form-control">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3 pull-left">
					Slug
				</label>
				<div class="col-sm-7">
					<input value="{{ $attribute->slug }}" name="attribute[slug]" type="text" placeholder="" class="form-control">
					<label class="checkbox-inline">
						<input type="checkbox" value="true" checked="" id="create-slug">
						Từ tên thuộc tính
					</label>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3 pull-left">
					Biểu tượng
				</label>
				<div class="col-sm-7">
					<input value="{{ $attribute->icon }}" name="attribute[icon]" type="text" placeholder="" class="form-control" />
					<span class="help-block"> Sử dụng fontawesome </span>
				</div>
			</div>
		</div>
		<div class="form-actions util-btn-margin-bottom-5">
			<div class="row">
				<div class="col-md-offset-3 col-md-9">
					@if(!isset($attribute_id))
						{!! Form::btnSaveNew() !!}
					@else
						{!! Form::btnSaveOut() !!}
					@endif
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
	<script type="text/javascript">
		$('#create-slug').click(function() {
			if(this.checked) {
				var title = $('input[name="attribute[name]"]').val();
				var slug = strSlug(title);
				$('input[name="attribute[slug]"]').val(slug);
			}
		});

		$('input[name="attribute[name]"]').keyup(function() {
			if ($('#create-slug').is(':checked')) {
				var title = $(this).val();
				var slug = strSlug(title);
				$('input[name="attribute[slug]"]').val(slug);	
			}
		});
	</script>
@endpush
