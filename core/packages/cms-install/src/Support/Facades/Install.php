<?php

namespace Packages\CmsInstall\Support\Facades;

use Illuminate\Support\Facades\Facade;

class Install extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return \Packages\CmsInstall\Services\Install::class;
    }
}
