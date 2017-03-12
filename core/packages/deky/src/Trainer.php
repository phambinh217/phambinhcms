<?php

namespace Packages\Deky;

use Packages\Cms\User;
use Illuminate\Database\Eloquent\Builder;

class Trainer extends User
{
    public function courses()
    {
        return $this->hasMany('Packages\Deky\Course');
    }
}
