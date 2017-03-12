<?php 

namespace Packages\Cms\Support\Facades;

use Illuminate\Support\Facades\Facade;

class AdminMenu extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Packages\Cms\Services\AdminMenu::class;
    }
}
