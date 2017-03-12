<?php

namespace Packages\Ecommerce\Services;

use Illuminate\Support\Collection;

class CartItemOptions extends Collection
{
    /**
     * Get the option by the given key.
     *
     * @param string $key
     * @return mixed
     */
    public function __get($key)
    {
        return $this->get($key);
    }
}