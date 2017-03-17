<?php

namespace Phambinh\CmsInstall\Support\Facades;

use Illuminate\Support\Facades\Facade;

class EnvReader extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return \Phambinh\CmsInstall\Services\EnvReader::class;
    }
}
