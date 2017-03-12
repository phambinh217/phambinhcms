<?php

namespace Packages\Appearance\Support\Facades;

use Illuminate\Support\Facades\Facade;

class Menu extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Packages\Appearance\Services\Menu::class;
    }
}
