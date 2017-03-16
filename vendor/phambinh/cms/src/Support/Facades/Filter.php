<?php

namespace Phambinh\Cms\Support\Facades;

use Illuminate\Support\Facades\Facade;

class Filter extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Phambinh\Cms\Services\Filter::class;
    }
}
