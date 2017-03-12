<?php 

namespace Packages\Ecommerce\Support\Facades;

use Illuminate\Support\Facades\Facade;

class Compare extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Packages\Ecommerce\Services\Compare::class;
    }
}
