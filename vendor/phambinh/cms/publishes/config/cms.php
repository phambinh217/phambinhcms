<?php

return [
    'dashboard-view-path'       => 'Cms::admin.dashboard',
    'upload_path'               => public_path('storage'),
    'thumb_path'                => public_path('storage/thumbs'),

    'providers' => [
        \Ixudra\Curl\CurlServiceProvider::class,
        \Collective\Html\HtmlServiceProvider::class,
        \Intervention\Image\ImageServiceProvider::class,
        \Phambinh\Cms\Providers\RoutingServiceProvider::class,

        /**
         * Packages providers
         */
        \Phambinh\Appearance\Providers\ModuleServiceProvider::class,
        \Phambinh\Appearance\Providers\RoutingServiceProvider::class,
        \Phambinh\News\Providers\ModuleServiceProvider::class,
        \Phambinh\News\Providers\RoutingServiceProvider::class,
        \Phambinh\Page\Providers\ModuleServiceProvider::class,
        \Phambinh\Page\Providers\RoutingServiceProvider::class,
        \Phambinh\FbComment\Providers\ModuleServiceProvider::class,
        \Phambinh\FbComment\Providers\RoutingServiceProvider::class,
        \Phambinh\CmsInstall\Providers\ModuleServiceProvider::class,
        \Phambinh\CmsInstall\Providers\RoutingServiceProvider::class,
    ],

    'aliases' => [
        'Form'              =>  \Collective\Html\FormFacade::class,
        'Html'              =>  \Collective\Html\HtmlFacade::class,
        'AccessControl'     =>  \Phambinh\Cms\Support\Facades\AccessControl::class,
        'AdminController'   =>  \Phambinh\Cms\Http\Controllers\Admin\AdminController::class,
        'AdminMenu'         =>  \Phambinh\Cms\Support\Facades\AdminMenu::class,
        'Contact'           =>  \Phambinh\Cms\Support\Facades\Contact::class,
        'Module'            =>  \Phambinh\Cms\Support\Facades\Module::class,
        'Setting'           =>  \Phambinh\Cms\Support\Facades\Setting::class,
        'Widget'            =>  \Phambinh\Cms\Support\Facades\Widget::class,
        'HomeController'    =>  \Phambinh\Cms\Http\Controllers\HomeController::class,
        'AppController'     =>  \Phambinh\Cms\Http\Controllers\AppController::class,
        'ApiController'     =>  \Phambinh\Cms\Http\Controllers\ApiController::class,
        'Language'          =>  \Phambinh\Cms\Support\Facades\Language::class,
        'Action'            =>  \Phambinh\Cms\Support\Facades\Action::class,
        'Filter'            =>  \Phambinh\Cms\Support\Facades\Filter::class,
        'Metatag'           =>  \Phambinh\Cms\Support\Facades\Metatag::class,
        'Asset'             =>  \Phambinh\Cms\Support\Facades\Asset::class,
        'Install'           =>  \Phambinh\CmsInstall\Support\Facades\Install::class,
        'EnvReader'         =>  \Phambinh\CmsInstall\Support\Facades\EnvReader::class,
        'Curl'              =>  \Ixudra\Curl\Facades\Curl::class,
        'Image'             =>  \Intervention\Image\Facades\Image::class,

        /**
         * Packages alias
         */
        'Menu'              =>  \Phambinh\Appearance\Support\Facades\Menu::class,
        'FbComment'         =>  \Phambinh\FbComment\Support\Facades\Comment::class,
    ],

    'commands' => [
        \Phambinh\CmsInstall\Console\Commands\CmsInstall::class,
    ],
];
