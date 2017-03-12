@extends('Home::layouts.default')

@section('content')
	<div class="ui container">
		<div class="ui massive breadcrumb">
			<a class="section" href="{{ url('/') }}">Trang chủ</a>
			<i class="right chevron icon divider"></i>
			<a class="section active">Giỏ so sánh</a>
		</div>
		@if(\Compare::count())
		<table class="ui compact celled definition table">
            <tbody>
                @foreach(setting('compare') as $compare => $name)
                    <tr>
                        <td style="min-width: 150px">
                        	{{ $name }}
                        </td>
                        @foreach(\Compare::content() as $compare_item)
                        	@php $product_item = $products->where('id', $compare_item->id)->first(); @endphp
                            @if($compare == 'product')
                                <td>
                                    <a href="{{ route('product.show', ['slug' => $product_item->slug, 'id' => $product_item->id]) }}"><strong>{{ $product_item->name }}</strong></a>
                                </td>

                            @elseif($compare == 'image')
                                <td class="text-center">
                                    <img src="{{ thumbnail_url($product_item->thumbnail, ['width' => '90', 'height' => '90']) }}" alt="{{ $product_item->name }}" title="{{ $product_item->name }}" class="img-thumbnail">
                                </td>

                            @elseif($compare == 'price')
                            	<td>
	                            	@if($product_item->isSale())
	                            		<span class="right floated">
			                            	{{ price_format($product_item->promotional_price) }}
			                            </span>
			                            <span class="right floated">
			                            	<s>{{ price_format($product_item->price) }}</s>
			                            </span>
		                            @else
			                            <span class="right floated">
			                            	{{ price_format($product_item->price) }}
			                            </span>
	                            	@endif
                            	</td>
                            
                            @elseif($compare == 'model')
								<td>{{ $product_item->code }}</td>

                            @elseif($compare == 'rating')
								<td></td>

							@elseif($compare == 'brand')
								<td>
									@foreach($product_item->brands as $brand_item)
										<a href="{{ route('product.brand', ['slug' => $brand_item->slug, 'id' => $brand_item->id]) }}" class="ui label">
											{{ $brand_item->name }}
										</a>
									@endforeach
								</td>

                            @elseif($compare == 'summary')
                                <td class="description">{{ $product_item->content }}</td>

                            @elseif($compare == 'action')
                                <td style="text-align: center!important">
                                	<div class="ui buttons">
	                                	<button compare="remove" data-refresh="true" data-rowid="{{ $compare_item->rowId }}" class="ui button">
	                                		<i class="remove icon"></i> Xóa
	                                	</button>
                                		<div class="or"></div>
                                		<button cart="add" data-rdr="true" data-id="{{ $product_item->id }}" class="ui positive button">
                                			<i class="cart icon"></i> Mua
                                		</button>
                                	</div>
                                </td>
                            @endif
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
		@else
			<h1 class="ui header">
				Giỏ so sánh
			</h1>
			<div class="sub header">Hãy <a href="{{ url('/') }}">quay lại cửa hàng</a> để thêm sản phẩm vào giỏ so sánh</div>
		@endif
		<div class="ui clearing segment">
			<a href="{{ url('/') }}" class="ui labeled icon button left floated">
				<i class="chevron left icon"></i>
				Tiếp tục mua
			</a>
		</div>
	</div>
@endsection

@push('js_footer')
<script type="text/javascript">
	$(function(){
		handleAjaxForm('*[ajax-form]', function(res){
			toastr.success(res.message, res.title);
			window.location = document.location.href;
		});
	});
</script>
@endpush