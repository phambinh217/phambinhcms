<?php

namespace Packages\Cms\Support\Facades;

use Illuminate\Support\Facades\Facade;

class AccessControl extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Packages\Cms\Services\AccessControl::class;
    }
}
