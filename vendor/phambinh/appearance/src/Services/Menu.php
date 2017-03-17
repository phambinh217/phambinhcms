<?php

namespace Phambinh\Appearance\Services;

use Illuminate\Support\Collection;

class Menu
{
    protected $menus;

    protected $locations;

    public function __construct()
    {
        $this->menus = new Collection();
        $this->locations = new Collection();
    }

    public function registerType($name, $type)
    {
        $this->menus->push([
            'name' => $name,
            'type' => $type,
        ]);
    }

    public function registerLocation($data)
    {
        $this->locations->push($data);
    }

    public function location()
    {
        return $this->locations;
    }

    public function menu()
    {
        return $this->menus;
    }

    /**
     * Gọi các phương thức trang collection
     * @param  string $method
     * @param  array $params
     * @return collection()
     */
    public function __call($method, $params)
    {
        if (starts_with($method, 'location')) {
            $method = camel_case(str_replace('location', null, $method));
            if (! method_exists($this, $method)) {
                return call_user_func_array([$this->locations, $method], $params);
            }
        } elseif (! method_exists($this, $method)) {
            return call_user_func_array([$this->menus, $method], $params);
        }
    }
}
