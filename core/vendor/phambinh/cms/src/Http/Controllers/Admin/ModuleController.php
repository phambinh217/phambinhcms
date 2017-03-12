<?php

namespace Phambinh\Cms\Http\Controllers\Admin;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Http\Request;

class ModuleController extends AdminController
{
    public function index()
    {
        $this->data['modules'] = \Module::where('type', 'module');
        \Metatag::set('title', trans('module.list-module'));
        return view('Cms::admin.module.index', $this->data);
    }
}
