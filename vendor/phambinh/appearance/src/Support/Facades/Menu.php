<?php

namespace Phambinh\Appearance\Support\Facades;

use Illuminate\Support\Facades\Facade;

class Menu extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Phambinh\Appearance\Services\Menu::class;
    }
}
