<?php

namespace Phambinh\Cms\Support\Facades;

use Illuminate\Support\Facades\Facade;

class Widget extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Phambinh\Cms\Services\Widget::class;
    }
}
