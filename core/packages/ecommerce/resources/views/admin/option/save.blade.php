@extends('Cms::layouts.default',[
    'active_admin_menu'     => [' ecommerce.option', isset($option_id) ? ' ecommerce.option.index' : ' ecommerce.option.create'],
    'breadcrumbs'           => [
        'title' => ['Cài đặt', 'Tùy chọn thuộc tính', isset($option_id) ? trans('cms.edit') : trans('cms.add-new')],
        'url'   => [

        ],
    ],
])

@section('page_title', isset($option_id) ? 'Chỉnh sửa tùy chọn' : 'Thêm tùy chọn mới' )

@if(isset($option_id))
    @section( 'page_sub_title', $option->name )
    @section( 'tool_bar' )
        <a href="{{ route('admin.ecommerce.option.create' ) }}" class="btn btn-primary">
            <i class="fa fa-plus"></i> Thêm tùy chọn
        </a>
    @endsection
@endif

@section( 'content' )
    <form method="post" action="{{ isset($option_id) ? route('admin.ecommerce.option.update', ['id' => $option_id]) : route('admin.ecommerce.option.store') }}" class="form-horizontal ajax-form" id="app-option">
    	<div class="form-body">
	        {{ csrf_field() }}
	        @if(isset($option_id)) 
	        	{{ method_field('PUT') }}
	        @endif
	        <div class="form-group">
	            <label class="col-sm-3 control-label">
	                Tên thuộc tính
	                <span class="required">*</span>
	            </label>
	            <div class="col-sm-7">
	                <input type="text" name="option[name]" value="{{ $option->name or '' }}" placeholder="Tên thuộc tính" class="form-control" />
	            </div>
	        </div>
	        <div class="form-group">
	            <label class="col-sm-3 control-label" for="input-type">
	                Kiểu tùy chọn
	                <span class="required">*</span>
	            </label>
	            <div class="col-sm-7">
					@include('Ecommerce::admin.components.form-select-option-type', [
						'types' => $option->getTypeAble()->groupBy('type'),
						'name' => 'option[type]',
						'selected' => '0',
						'attributes' => 'v-model="type" @change="toggleShowValues"',
					])
	            </div>
	        </div>
	        <div class="form-group">
	        	<div class="col-sm-offset-3 col-sm-9">
	        		<div v-show="showTable">
	        			<table class="table master-table table-striped table-bordered table-hover">
			                <thead>
			                    <tr>
			                    	<th></th>
			                        <th class="text-center">Tên giá trị thuộc tính</th>
			                        <th class="text-center">Hình ảnh</th>
			                        <th></th>
			                    </tr>
			                </thead>
			                <tbody id="option-values">
			                	<tr v-for="(value_item, index) in values">
			                		<td class="text-center">
			                    		<i class="fa-arrows fa cur-move"></i>
			                    	</td>
			                		<td>
			                			<input type="text" :name="'values['+value_item.id+'][value]'" placeholder="Tên giá trị thuộc tính" class="form-control" :value="value_item.value" />
			                		</td>
			                		<td class="text-center">
			                			<div class="media-box-group">
			                				<input type="hidden" class="hide file-input" :name="'values['+value_item.id+'][image]'" :value="value_item.image" />
			                				<div class="row">
			                					<div class="col-lg-5">
			                						<div class="mt-element-card mt-element-overlay">
			                							<div class="mt-card-item">
			                								<div class="mt-overlay-1 fileinput-new">
			                									<div class="fileinput-new">
			                										<img :src="value_item.image" class="image-preview" style="max-width: 150px; max-height: 150px"/>
			                									</div>
			                									<div class="fileinput-preview fileinput-exists"></div>
			                									<div class="mt-overlay">
			                										<ul class="mt-info">
			                											<li>
			                												<a class="btn default btn-outline open-file-broswer">
			                													<i class="fa fa-upload"></i>
			                												</a>
			                											</li>
			                											<li>
			                												<a class="btn default btn-outline">
			                													<i class="fa fa-times"></i>
			                												</a>
			                											</li>
			                										</ul>
			                									</div>
			                								</div>
			                							</div>
			                						</div>
			                					</div>
			                				</div>
			                			</div>
			                		</td> 
			                		<td class="text-left">
			                			<button type="button" @click.prevent="removeValue(index,value_item)" title="Remove" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button>
			                		</td>
			                	</tr>
			                    <tr>
			                        <td colspan="3"></td>
			                        <td class="text-left">
			                            <button type="button" @click.prevent="addValue" class="btn btn-primary">
			                                <i class="fa fa-plus-circle"></i>
			                            </button>
			                        </td>
			                    </tr>
			                </tbody>
			            </table>
			        </div>
	        	</div>
	        </div>
        </div>
        <div class="form-actions util-btn-margin-bottom-5">
			<div class="row">
				<div class="col-md-offset-3 col-md-9">
					@if(!isset($option_id))
						{!! Form::btnSaveNew() !!}
					@else
						{!! Form::btnSaveOut() !!}
					@endif
				</div>
			</div>
		</div>
    </form>
@endsection

@push( 'css' )
    <link href="{{ url( 'assets/admin/global/plugins/bootstrap-toastr/toastr.min.css' )}}" rel="stylesheet" type="text/css" />
@endpush

@push( 'js_footer' )
	<script type="text/javascript" src="{{ url( 'assets/admin/global/plugins/jquery-form/jquery.form.min.js' ) }}"></script>
	<script type="text/javascript" src="{{ url( 'assets/admin/global/plugins/bootstrap-toastr/toastr.min.js' ) }}"></script>
	<script type="text/javascript" src="{{ asset_url('admin', 'global/plugins/vuejs/js/vue.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset_url('admin', 'global/plugins/vue-sortable/sortable.js') }}"></script>
    <script type="text/javascript" src="{{ asset_url('admin', 'global/plugins/vue-sortable/vue-sortable.js') }}"></script>
	<script type="text/javascript">
	    var appOption = new Vue({
	        el: '#app-option',
	        data: {
	            values: {!! $option->values->sortBy('order')->values()->toJson() !!},
	            type: '{{ $option->type }}',
	            showTable: false,
	        },
	        methods: {
	            toggleShowValues: function() {
	                switch(this.type) {
	                    case 'select': case 'radio': case 'checkbox':  case 'image':
	                        this.showTable = true;
	                        break;
	                    default:
	                        this.showTable = false;
	                        break;
	                }
	            },
	            addValue: function() {
	                this.values.push({
	                	id: - Date.now(),
	                	option_id: {{ isset($option_id) ? $option_id : '- Date.now() - 1' }},
	                    value: '',
	                    image: '{{ setting('default-thumbnail') }}',
	                });
	            },
	            removeValue: function(index, value) {
	            	if (confirm('Bạn có chắc muốn xóa')) {
	            		var app = this;
	            		if (value.id < 0 && value.option_id < -1) {
	            			this.values.splice(index, 1);
	            		} else {
	            			$.ajax({
	            				url: '{{ admin_url('shop/option/') }}' + '/value/' + value.id,
	            				type: 'post',
	            				dataType: 'json',
	            				data: {
	            					_token: csrfToken(),
	            					_method: 'delete',
	            				},
	            				success: function() {
	            					app.values.splice(index, 1);
	            				}
	            			});
	            		}
	            	}
	            },
	        },
	        mounted: function(){
			    var self = this;
			    self.$nextTick(function(){
			        var sortable = Sortable.create(document.getElementById('option-values'), {
			            onEnd: function(e) {
			                var clonedItems = self.values.filter(function(item){
			                    return item;
			                });
			                clonedItems.splice(e.newIndex, 0, clonedItems.splice(e.oldIndex, 1)[0]);
			                self.values = [];
			                self.$nextTick(function(){
			                    self.values = clonedItems;
			                });
			            }
			        }); 
			    });
			}
	    });
	    appOption.toggleShowValues();
	</script>
@endpush
