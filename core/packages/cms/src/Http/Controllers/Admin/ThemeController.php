<?php

namespace Packages\Cms\Http\Controllers\Admin;

use Illuminate\Http\Request;

class ThemeController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->data['themes'] = \Module::where('type', 'theme');
        \Metatag::set('title', trans('module.list-module'));
        return view('Cms::admin.theme.index', $this->data);
    }
}
