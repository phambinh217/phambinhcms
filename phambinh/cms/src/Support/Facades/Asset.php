<?php

namespace Phambinh\Cms\Support\Facades;

use Illuminate\Support\Facades\Facade;

class Asset extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Phambinh\Cms\Services\Asset::class;
    }
}
