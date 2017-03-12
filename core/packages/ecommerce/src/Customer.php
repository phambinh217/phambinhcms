<?php

namespace Packages\Ecommerce;

use Packages\Ecommerce\User;

class Customer extends User
{
    public function orders()
    {
        return $this->hasMany('Packages\Ecommerce\Order', 'customer_id');
    }
}
