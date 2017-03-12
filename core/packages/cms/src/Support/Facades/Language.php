<?php

namespace Packages\Cms\Support\Facades;

use Illuminate\Support\Facades\Facade;

class Language extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Packages\Cms\Services\Language::class;
    }
}
