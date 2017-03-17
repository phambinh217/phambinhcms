<?php

namespace Phambinh\FbComment\Support\Facades;

use Illuminate\Support\Facades\Facade;

class Comment extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return \Phambinh\FbComment\Services\Comment::class;
    }
}
