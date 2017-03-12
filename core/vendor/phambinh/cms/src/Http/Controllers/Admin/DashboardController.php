<?php

namespace Phambinh\Cms\Http\Controllers\Admin;

class DashboardController extends AdminController
{
    public function index()
    {
        \Metatag::set('title', trans('cms.dashboard'));
        return view(config('cms.dashboard-view-path'), $this->data);
    }
}
