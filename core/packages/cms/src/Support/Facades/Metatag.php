<?php

namespace Packages\Cms\Support\Facades;

use Illuminate\Support\Facades\Facade;

class Metatag extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Packages\Cms\Services\Metatag::class;
    }
}
