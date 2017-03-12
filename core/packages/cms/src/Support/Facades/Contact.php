<?php 

namespace Packages\Cms\Contact\Support\Facades;

use Illuminate\Support\Facades\Facade;

class Contact extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Packages\Cms\Services\Contact::class;
    }
}
