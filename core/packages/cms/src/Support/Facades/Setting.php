<?php

namespace Packages\Cms\Support\Facades;

use Illuminate\Support\Facades\Facade;

class Setting extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Packages\Cms\Services\Setting::class;
    }
}
