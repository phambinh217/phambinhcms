@if(\Cart::count())
    <table class="ui very basic collapsing celled table">
        <tbody>
            @php $products = \Packages\Ecommerce\Product::whereIn('id', \Cart::content()->pluck('id'))->get(); @endphp
            @foreach(\Cart::content() as $cart_item)
                @php $product_item = $products->where('id', $cart_item->id)->first(); @endphp
                <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>
                        <a href="{{ route('product.show', ['slug' => $product_item->slug, 'id' => $product_item->id]) }}">
                            <img src="{{ thumbnail_url($product_item->thumbnail, ['width' => 74, 'height' => 74]) }}" />
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('product.show', ['slug' => $product_item->slug, 'id' => $product_item->id]) }}">{{ $product_item->name }}</a>
                        @if(count($cart_item->options))
                            <ul class="ui list">
                                @foreach($cart_item->options as $option_id => $value_id)
                                    @php
                                        $option = \DB::table('product_to_option_value')
                                        ->distinct()
                                        ->select('options.name', 'option_values.value')
                                        ->join('option_values', 'product_to_option_value.value_id', '=', 'option_values.id')
                                        ->join('options', 'product_to_option_value.option_id', 'options.id')
                                        ->where('options.id', $option_id)
                                        ->whereIn('product_to_option_value.value_id', (array) $value_id)
                                        ->get();
                                    @endphp
                                    <li>{{ $option->first()->name }}: {{ $option->implode('value', ', ') }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </td>
                    <td>
                        <div class="ui form">
                            x{{ $cart_item->qty }}
                        </div>
                    </td>
                    <td>{{ price_format($cart_item->price) }}</td>
                    <td>
                        <button cart="remove" data-rowid="{{ $cart_item->rowId }}" class="ui icon button negative" data-tooltip="Xóa khỏi giỏ hàng" data-position="bottom left" data-inverted>
                            <i class="remove icon"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ route('cart.index') }}" class="ui labeled icon button left floated primary">
        <i class="cart icon"></i>
        Xem giỏ hàng
    </a>
    <a href="{{ route('checkout.index') }}" class="ui labeled icon button right floated positive">
        <i class="checkmark icon"></i>
        Thanh toán
    </a>
@else
    <h4 class="header">Giỏ hàng trống</h4>
@endif