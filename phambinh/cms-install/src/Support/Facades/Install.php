<?php

namespace Phambinh\CmsInstall\Support\Facades;

use Illuminate\Support\Facades\Facade;

class Install extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return \Phambinh\CmsInstall\Services\Install::class;
    }
}
