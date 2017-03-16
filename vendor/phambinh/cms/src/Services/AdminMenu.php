<?php

namespace Phambinh\Cms\Services;

use Illuminate\Support\Collection;

class AdminMenu
{
    protected $menus;

    protected $menusbar;

    public function __construct()
    {
        $this->menus = new Collection();
        $this->menusbar = new Collection();
    }

    public function register($id, $menu, $order = 1)
    {
        if (!isset($menu['order'])) {
            $menu['order'] = $this->menus->count() + 1;
        }
        $menu['id'] = $id;
        $this->menus->push($menu);
    }

    /**
     * Gọi các phương thức trang collection
     * @param  string $method
     * @param  array $params
     * @return collection()
     */
    public function __call($method, $params)
    {
        if (starts_with($method, 'adminbar')) {
            $method = camel_case(str_replace('adminbar', null, $method));
            if (! method_exists($this, $method)) {
                return call_user_func_array([$this->menusbar, $method], $params);
            }
        } elseif (! method_exists($this, $method)) {
            return call_user_func_array([$this->menus, $method], $params);
        }
    }
}
