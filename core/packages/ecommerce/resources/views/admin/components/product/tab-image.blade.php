<div class="table-responsive" id="app-product-image">
	<table id="images" class="table table-striped table-bordered table-hover">
		<thead>
			<tr>
				<th width="50px" class="text-center"></th>
				<th class="text-left">Hình ảnh</th>
				<th></th>
			</tr>
		</thead>
		<tbody id="product-images">
			<tr v-for="(image_item, index) in product_images" is="ImageItem" :image_item="image_item" :index="index"></tr>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="2"></td>
				<td class="text-left">
					<button type="button" class="btn btn-primary" @click.prevent="addImage">
						<i class="fa fa-plus-circle"></i>
					</button>
				</td>
			</tr>
		</tfoot>
	</table>
</div>

@push('js_footer')
	<script type="text/x-template" id="image-item-cpn">
		<tr>
			<td class="text-center">
				<i class="fa-arrows fa cur-move"></i>
			</td>
			<td>
				<div class="media-box-group">
					<input type="hidden" :name="'images['+index+'][url]'" class="hide file-input" :value="image_item.url" />
					<div class="row">
						<div class="col-lg-4">
							<div class="mt-element-card mt-element-overlay">
								<div class="mt-card-item">
									<div class="mt-overlay-1 fileinput-new">
										<div class="fileinput-new">
											<img :src="image_item.url" class="image-preview" style="max-width: 150px; max-height: 150px"/>
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
			<td>
				<button type="button" @click.prevent="remove" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button>
			</td>
		</tr>
	</script>
	<script type="text/javascript">

		Vue.component('ImageItem', {
			template: '#image-item-cpn',
			props: ['image_item', 'index'],
			methods: {
				remove: function() {
					if (!confirm("Bạn có chắc muốn xóa")) {
						return false;
					}
					this.$el.remove();
				}
			},
		});

		var appImage = new Vue({
			el: '#app-product-image',
			data: {
				product_images: {!! $product_images->toJson() !!},
			},
			methods: {
				addImage: function() {
					this.product_images.push({
						url: '{!! $product->thumbnail !!}',
						order: 1,
					});
				},
				removeImage: function(index) {
					if (confirm('Bạn có chắc muốn xóa')) {
						this.product_images.splice(index, 1);
					}
				},
			},
			mounted: function(){
			    var self = this;
			    self.$nextTick(function(){
			        var sortable = Sortable.create(document.getElementById('product-images'), {
			            onEnd: function(e) {
			                var clonedItems = self.product_images.filter(function(item){
			                    return item;
			                });
			                clonedItems.splice(e.newIndex, 0, clonedItems.splice(e.oldIndex, 1)[0]);
			                self.product_images = [];
			                self.$nextTick(function(){
			                    self.product_images = clonedItems;
			                });
			            }
			        }); 
			    });
			}
		});
	</script>
@endpush