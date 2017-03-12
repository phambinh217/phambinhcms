<?php

namespace Packages\Ecommerce;

use Packages\Cms\User as CmsUser;

class User extends CmsUser
{
    public function products()
    {
        return $this->hasMany('Packages\Ecommerce\Product', 'author_id');
    }
}
