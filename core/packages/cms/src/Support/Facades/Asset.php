<?php

namespace Packages\Cms\Support\Facades;

use Illuminate\Support\Facades\Facade;

class Asset extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Packages\Cms\Services\Asset::class;
    }
}
