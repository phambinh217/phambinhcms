<?php

namespace Packages\Ecommerce\Support\Facades;

use Illuminate\Support\Facades\Facade;

class Cart extends Facade {
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return \Packages\Ecommerce\Services\Cart::class;
    }
}
