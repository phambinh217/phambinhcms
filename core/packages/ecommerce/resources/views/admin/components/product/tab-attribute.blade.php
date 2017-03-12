<div class="table-responsive" id="app-product-attribute">
	<table id="attribute" class="table table-striped table-bordered table-hover">
		<thead>
			<th width="50px" class="text-center"></th>
			<th style="max-width: 100px" class="text-left">Thuộc tính</th>
			<th class="text-left">Giá trị</th>
			<th></th>
		</thead>
		<tbody id="product-attributes">
			<tr v-for="(attribute_item, index) in product_attributes" is="attributeItemCpn" :attribute=attribute_item :attributes="attributes">
			</tr>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="3"></td>
				<td>
					<button class="btn btn-primary" type="button" @click.prevent="addAttr">
						<i class="fa fa-plus"></i>
					</button>
				</td>
			</tr>
		</tfoot>
	</table>
</div>

@push('html_footer')
	<script type="text/x-template" id="attribute-item-cpn">
		<tr>
			<td class="text-center">
				<i class="fa-arrows fa cur-move"></i>
			</td>
			<td style="max-width: 100px">
				<input type="text" class="form-control" :id="'attribute-name-'+attribute.id" :value="attribute.name" />
			</td>
			<td>
				<textarea :name="'attributes['+attribute.id+']'" class="form-control">@{{ attribute.pivot.value }}</textarea>
			</td>
			<td>
				<button type="button" @click.prevent="remove" class="btn btn-danger">
					<i class="fa fa-minus-circle"></i>
				</button>
			</td>
		</tr>
	</script>
@endpush

@push('js_footer')
	<script type="text/javascript" src="{{ asset_url('admin', 'global/plugins/typeahead/handlebars.min.js') }}"></script>
	<script type="text/javascript">
		Vue.component('attributeItemCpn', {
			template: '#attribute-item-cpn',
			props: ['attribute', 'attributes'],
			data: function () {
				return {};
			},

			mounted: function(){
			    var self = this;
			    self.$nextTick(function(){
			    	var attributes = new Bloodhound({
			    		datumTokenizer: function(d) { return Bloodhound.tokenizers.whitespace(d.name); },
			    		queryTokenizer: Bloodhound.tokenizers.whitespace,
			    		limit: 10,
			    		local: self.attributes,
			    	});
			    	attributes.initialize();
			    	
			    	$('#attribute-name-'+self.attribute.id).typeahead({highlight: true}, {
			    		displayKey: 'name',
			    		hint: (App.isRTL() ? false : true),
			    		source: attributes.ttAdapter()
			    	});

			    	$('#attribute-name-'+self.attribute.id).bind('typeahead:close', function() {
			    		var attributeName = $(this).typeahead('val');
			    		if (attributeName.trim() != '') {
			    			self.createAttr(attributeName);
			    		}
			    	});
			    });
			},

			methods: {
				remove: function(e) {
					if (confirm('Bạn có chắc muốn xóa')) {
						this.$el.remove();
					}
				},

				findAttr: function(attributeName) {
					var attr = false;
					this.attributes.forEach(function(item, index) {
						if (item.name == attributeName) {
							attr = item;
						}
					});

					return attr;
				},

				createAttr: function(attributeName) {
					var app = this;
					var attribute = this.findAttr(attributeName);
					if (! attribute) {
						this.$http.post('{{ url('api/v1/ecommerce/attribute/first-or-create') }}', {name: attributeName, _token: csrfToken()}).then(function(res){
							attribute = res.body;
							app.attribute.id = attribute.id;
							app.attribute.name = attribute.name;
							app.attribute.pivot.attribute_id = attribute.id;
						});
					} else { 
						app.attribute.id = attribute.id;
						app.attribute.name = attribute.name;
						app.attribute.pivot.attribute_id = attribute.id;
					}
				},
			},
		});

		var appAttribute = new Vue({
			el: '#app-product-attribute',
			data: {
				product_attributes: {!! $product_attributes->toJson() !!},
				attributes: {!! $attributes->toJson() !!},
			},

			mounted: function(){
			    var self = this;
			    self.$nextTick(function(){
			        var sortable = Sortable.create(document.getElementById('product-attributes'), {
			            onEnd: function(e) {
			                var clonedItems = self.product_attributes.filter(function(item){
			                    return item;
			                });
			                clonedItems.splice(e.newIndex, 0, clonedItems.splice(e.oldIndex, 1)[0]);
			                self.product_attributes = [];
			                self.$nextTick(function(){
			                    self.product_attributes = clonedItems;
			                });
			            }
			        }); 
			    });
			},

			methods: {
				addAttr: function() {
					this.product_attributes.push({
						id: Date.now(),
						name: '',
						pivot: {
							value: '',
							attribute_id: Date.now(),
						},
					});
				},
			}
		});
	</script>
@endpush
