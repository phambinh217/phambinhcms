<?php 
/**
 * ModuleAlias: shop
 * ModuleName: shop
 * Description: Helper functions of module shop
 * @author: noname
 * @version: 1.0
 * @package: PackagesCMS
 */

if (!function_exists('price_format')) {
    function price_format($price = null)
    {
        if ($price) {
            $currency = setting('currency');
            return $currency['symbol_left'] .' '.number_format($price, config('cart.format.decimals'), config('cart.format.decimal_point'), ' ').' '.$currency['symbol_right'];
        }

        return $price;
    }
}
