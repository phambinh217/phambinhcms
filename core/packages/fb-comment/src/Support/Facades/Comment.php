<?php

namespace Packages\FbComment\Support\Facades;

use Illuminate\Support\Facades\Facade;

class Comment extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return \Packages\FbComment\Services\Comment::class;
    }
}
