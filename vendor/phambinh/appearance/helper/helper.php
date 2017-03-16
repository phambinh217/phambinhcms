<?php

if (!function_exists('menu_items')) {
    function menu_items($menu_location)
    {
        $menu = \Phambinh\Appearance\Menu::where('location', $menu_location)->with('items')->first();
        if ($menu) {
            return $menu->items->sortBy('order')->values();
        }

        return collect();
    }
}
