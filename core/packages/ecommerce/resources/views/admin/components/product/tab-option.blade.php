<div class="row" id="app-product-option">
	<div class="col-md-2 col-sm-2 col-xs-2">
		<ul class="nav nav-tabs tabs-left" v-if="product_options.length != 0">
			<li is="optionItemTabCpn" v-for="(option_item, index) in product_options" :option="option_item" v-bind:class="index == 0 ? 'active' : ''"></li>
		</ul>
		<button class="btn btn-primary" style="width:100%" @click.prevent="addOption">Thêm</button>
	</div>
	<div class="col-md-10 col-sm-10 col-xs-10" style="margin-left: -15px;">
		<div class="tab-content">
			<div v-for="(option_item, index) in product_options" is="optionItemPanelCpn" v-on:addvalue="addOptionValue(option_item.id)" :option="option_item" :values="getValuesOfOptionId(option_item.id)" :all_values="getAllValuesOfOptionId(option_item.id)" :all_options="options" v-bind:class="'tab-pane ' + (index == 0 ? 'active' : '')" v-bind:id="'tab_option_' + option_item.id"></div>
		</div>
	</div>
</div>

@push('html_footer')
	<script type="text/x-template" id="option-item-tab-cpn">
		<li>
			<a v-bind:href="'#tab_option_' + option.id" class="hover-display-container"  data-toggle="tab" aria-expanded="true">
				@{{ option.name }}
				<div class="pull-right hover-display">
					<span class="text-italic text-danger cur-pointer" @click.prevent="remove">[Xóa]</span>
				</div>
			</a>
		</li>
	</script>
	<script type="text/x-template" id="option-item-panel-cpn">
		<div v-bind:class="'tab-pane'" v-bind:id="'tab_option_' + option.id">
			<div class="form-horizontal">
				<div class="form-group">
					<label class="col-sm-2 control-label">Tên</label>
					<div class="col-sm-7">
						<input type="text" class="form-control" :id="'option-name-'+option.id" :value="option.name" @keyup="changeOptionName($event)" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="input-required5">Kiểu</label>
					<div class="col-sm-7">
						<select :name="'options['+option.id+'][type]'" class="form-control width-auto">
							<option v-bind:selected="option.pivot.type == 'select' ? true : false" value="select">Select</option>	
							<option v-bind:selected="option.pivot.type == 'checkbox' ? true : false" value="checkbox">Checkbox</option>	
							<option v-bind:selected="option.pivot.type == 'radio' ? true : false" value="radio">Radio</option>	
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="input-required5">Bắt buộc</label>
					<div class="col-sm-7">
						<select :name="'options['+option.id+'][required]'" class="form-control width-auto">
							<option v-for="required_item in required_options" v-bind:selected="(required_item.id == 'true' && option.pivot.required == 1) ? true: false" :value="required_item.id">@{{ required_item.name }}</option>
						</select>
					</div>
				</div>
			</div>
			<div class="">
				<table class="table table-striped table-bordered table-hover">
					<thead>
						<tr>
							<th class="text-center">Giá trị</th>
							<th class="text-center">Trừ trong kho</th>
							<th class="text-center">Giá</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="value_item in values" is="optionValueItemCpn" :option_id="option.id" :value="value_item" :values="all_values"></tr>
					</tbody>
					<tfoot>
						<tr>
							<td colspan="3"></td>
							<td>
								<button class="btn btn-primary" @click.prevent="addValue"><i class="fa fa-plus"></i></button>
							</td>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
	</script>
	<script type="text/x-template" id="option-value-item-cpm">
		<tr>
			<td>
				<input type="text" class="form-control" :id="'option-value-item-'+value.id" name="" :value="value.value" />
			</td>
			<td>
				<div class="form-group">
					<div class="col-sm-5">
						<select :name="'options['+value.option_id+'][value]['+value.pivot.value_id+'][subtract]'" class="form-control width-auto" @change="changeSubtract($event)">
							<option v-for="subtract_item in subtract_options" v-bind:selected="value.pivot.subtract == 1 && subtract_item.slug == 'true' ? true: false" :value="subtract_item.slug">@{{ subtract_item.name }}</option>
						</select>
					</div>
					<div v-bind:class="value.pivot.subtract == 0 ? 'col-sm-7 hidden' : 'col-sm-7'" style="margin-left: -15px">
						<input :name="'options['+value.option_id+'][value]['+value.pivot.value_id+'][quantity]'" :value="value.pivot.quantity" placeholder="Số lượng" type="number" class="form-control" />
					</div>
				</div>
			</td>
			<td>
				<div class="form-group">
					<div class="col-sm-5">
						<select :name="'options['+value.option_id+'][value]['+value.pivot.value_id+'][prefix]'" class="form-control">
							<option v-for="prefix_item in prefix_options" v-bind:selected="prefix_item.id == value.pivot.prefix ? true: false" :value="prefix_item.id">@{{ prefix_item.name }}</option>
						</select>
					</div>
					<div class="col-sm-7" style="margin-left: -15px">
						<input :value="value.pivot.price" :name="'options['+value.option_id+'][value]['+value.pivot.value_id+'][price]'" type="number" class="form-control" />
					</div>
				</div>
			</td>
			<td>
				<button type="button" @click="remove" title="Remove" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button>
			</td>
		</tr>
	</script>
@endpush

@push('js_footer')
	<script type="text/javascript">
		Vue.component('optionItemTabCpn', {
			template: '#option-item-tab-cpn',
			props: ['option'],
			data: function() {
				return {
					
				};
			},
			methods: {
				remove: function() {
					this.$parent.removeOption(this.option.id);
				},
			},
		});

		Vue.component('optionItemPanelCpn', {
			template: '#option-item-panel-cpn',
			props: ['option', 'values', 'all_options', 'all_values'],
			data: function() {
				return {
					type: 'select',
					required_options: [
						{id: 'false', name: 'Không'},
						{id: 'true', name: 'Có'},
					],
				};
			},
			mounted: function(){
			    var self = this;
			    self.$nextTick(function(){
			    	var options = new Bloodhound({
			    		datumTokenizer: function(d) { return Bloodhound.tokenizers.whitespace(d.name); },
			    		queryTokenizer: Bloodhound.tokenizers.whitespace,
			    		limit: 10,
			    		local: self.all_options,
			    	});
			    	options.initialize();
			    	
			    	$('#option-name-'+self.option.id).typeahead({highlight: true}, {
			    		displayKey: 'name',
			    		hint: (App.isRTL() ? false : true),
			    		source: options.ttAdapter()
			    	});

			    	$('#option-name-'+self.option.id).bind('typeahead:close', function() {
			    		var optionName = $(this).typeahead('val');
			    		if (optionName.trim() != '') {
			    			self.createOption(optionName);
			    		}
			    	});
			    });
			},
			methods: {
				addValue: function() {
					console.log("Add value for option", this.option.id);
					this.$emit('addvalue');
				},
				findOption: function(optionName) {
					var option = false;
					var app = this;
					this.all_options.filter(function(item){
						if (item.name == optionName) {
							option = item;
						}
					});
					return option;
				},

				createOption: function(optionName) {
					var app = this;
					var option = this.findOption(optionName);
					if (! option) {
						this.$http.post('{{ url('api/v1/ecommerce/option/first-or-create') }}', {name: optionName, type:  'select', _token: csrfToken()}).then(function(res){
							option = res.body;
							app.option.id = option.id;
							app.option.name = option.name;
							app.option.type = option.type;
							app.option.pivot.option_id = option.id;
							app.option.pivot.required = 0;
							app.option.pivot.type = option.type;
							app.option.pivot.value = '';
						});
					} else { 
						app.option.id = option.id;
						app.option.name = option.name;
						app.option.type = option.type;
						app.option.pivot.option_id = option.id;
						app.option.pivot.required = 0;
						app.option.pivot.type = option.type;
						app.option.pivot.value = '';
					}
				},

				changeOptionName: function(e) {
					var option_id = this.option.id;
					this.$parent.updateOption(option_id, {name: e.target.value});
				},
			},
		});

		Vue.component('optionValueItemCpn', {
			template: '#option-value-item-cpm',
			props: ['value', 'values', 'option_id'],
			data: function() {
				return {
					subtract_options: {!! json_encode($product->getSubtractAble()) !!},
					prefix_options: [
						{id: '+', name: '+'},
						{id: '-', name: '-'},
					],
				};
			},
			mounted: function(){
			    var self = this;
			    self.$nextTick(function(){
			    	var values = new Bloodhound({
			    		datumTokenizer: function(d) { return Bloodhound.tokenizers.whitespace(d.value); },
			    		queryTokenizer: Bloodhound.tokenizers.whitespace,
			    		limit: 10,
			    		local: self.values,
			    	});
			    	values.initialize();
			    	
			    	$('#option-value-item-'+self.value.id).typeahead({highlight: true}, {
			    		displayKey: 'value',
			    		hint: (App.isRTL() ? false : true),
			    		source: values.ttAdapter()
			    	});

			    	$('#option-value-item-'+self.value.id).bind('typeahead:close', function() {
			    		var optionValue = $(this).typeahead('val');
			    		if (optionValue.trim() != '') {
			    			self.createOptionValue(optionValue);
			    		}
			    	});
			    });
			},
			methods: {
				findOptionValue: function(optionValue) {
					var value = false;
					this.values.filter(function(item){
						if (item.optionValue == item.value) {
							value = item;
						};
					});
					return value;
				},

				createOptionValue: function(optionValue) {
					var app = this;
					var value = this.findOptionValue(optionValue);
					if (! value) {
						this.$http.post('{{ url('api/v1/ecommerce/option-value/first-or-create') }}', {value: optionValue, option_id: this.option_id, _token: csrfToken()}).then(function(res){
							value = res.body;
							app.value.id = value.id;
							app.value.value = value.value;
							app.value.pivot.value_id = value.id;
						});
					} else { 
						app.value.id = value.id;
						app.value.value = value.value;
						app.value.pivot.value_id = value.id;
					}
				},
				remove: function() {
					if (confirm('Bạn có chắc muốn xóa')) {
						this.$el.remove();
					}
				},
				changeSubtract: function(e) {
					this.value.pivot.subtract = (e.target.value == 'true' ? '1' : '0');
				},
			},
		});

		var appOption = new Vue({
			el: '#app-product-option',
			data: {
				activeIndex: 0,
				product_options: {!! $product_options->toJson() !!},
				product_option_values: {!! $product_option_values->toJson() !!},

				options: {!! $options->toJson() !!},
				values: {!! $values->toJson() !!},
			},
			methods: {
				updateOption: function(option_id, data) {
					var app = this;
					this.product_options.forEach(function(item, index){
						if (item.id == option_id) {
							app.product_options[index] = $.extend(app.product_options[index], data);
						}
					});
				},

				addOption: function() {
					this.product_options.push({
						id: Date.now(),
						name: 'Mới',
						type: 'select',
						pivot: {
							option_id: Date.now(),
							required: 0,
							value: '',
							type: 'select',
						},
					});
				},

				removeOption: function(option_id) {
					var app = this;
					if (confirm('Bạn có chắc muốn xóa')) {
						this.product_options.forEach(function(item, index){
							if (item.id == option_id) {
								app.product_options.splice(index, 1);
							}
						});
						this.product_option_values.forEach(function(item, index){
							if (item.option_id == option_id) {
								app.product_option_values.splice(index, 1);
							}
						});
					}
				},

				getAllValuesOfOptionId: function(option_id) {
					var values = this.values.filter(function(item){
						return item.option_id == option_id;
					});
					return values;
				},

				getValuesOfOptionId: function(option_id) {
					var values = this.product_option_values.filter(function(item){
						return item.option_id == option_id;
					});
					return values;
				},

				addOptionValue: function(option_id) {
					this.product_option_values.push({
						id: Date.now(),
						option_id: option_id,
						value: '',
						pivot: {
							value_id: Date.now(),
							option_id: option_id,
							prefix: '+',
							subtract: 0,
							quantity: 0,
							price: 0,
						}
					});
				},
			}
		});
	</script>
@endpush