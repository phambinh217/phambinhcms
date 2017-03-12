<?php

namespace Phambinh\Cms\Services;

use Illuminate\Support\Collection;

class Widget
{
    protected $widgets;

    public function __construct()
    {
        $this->widgets = new Collection();
    }

    public function register($class, $data = [], $id = null)
    {
        if (!$id) {
            $id = $class;
        }

        $this->widgets->push(array_merge([
            'id'       => $id,
            'instance' => new $class()
        ], $data));
    }

    public function run($id, $params = null)
    {
        $widget = $this->where('id', $id)->first();
        if ($widget) {
            if ($params) {
                return $widget['instance']->run($params);
            }
            return $widget['instance']->run();
        } elseif (class_exists($id)) {
            $this->register($id);
            return $this->run($id, $params);
        }
    }

    public function __call($method, $params)
    {
        if (! method_exists($this, $method)) {
            return call_user_func_array([$this->widgets, $method], $params);
        }
    }
}
