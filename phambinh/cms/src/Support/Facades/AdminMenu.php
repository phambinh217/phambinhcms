<?php 

namespace Phambinh\Cms\Support\Facades;

use Illuminate\Support\Facades\Facade;

class AdminMenu extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Phambinh\Cms\Services\AdminMenu::class;
    }
}
