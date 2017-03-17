<?php

namespace Phambinh\Cms\Support\Abstracts;

abstract class Widget
{
    protected $data = [];
    
    abstract public function run($params = null);
}
