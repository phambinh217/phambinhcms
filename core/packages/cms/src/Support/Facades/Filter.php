<?php

namespace Packages\Cms\Support\Facades;

use Illuminate\Support\Facades\Facade;

class Filter extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Packages\Cms\Services\Filter::class;
    }
}
