<?php

namespace Packages\Cms\Support\Facades;

use Illuminate\Support\Facades\Facade;

class Widget extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Packages\Cms\Services\Widget::class;
    }
}
