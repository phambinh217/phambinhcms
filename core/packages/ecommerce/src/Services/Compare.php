<?php 
/**
 * ModuleAlias: shop
 * ModuleName: shop
 * Description: Nhớ các sản phẩm trong session đế so sanh sản phẩm
 * @author: noname
 * @version: 1.0
 * @package: PackagesCMS
 */
namespace Packages\Ecommerce\Services;

class Compare
{
    protected $instance;

    public function __construct(\Packages\Ecommerce\Services\Cart $cart)
    {
        $this->instance = $cart->instance('compare');
    }

    public function __call($method, $params = [])
    {
        if (! method_exists($this, $method)) {
            return call_user_func_array([$this->instance, $method], $params);
        }
    }
}
