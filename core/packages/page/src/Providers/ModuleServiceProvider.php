<?php

namespace Packages\Page\Providers;

use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // Load views
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'Page');

        // Load translations
        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', 'Page');

        // Load helper
        if (\File::exists(__DIR__ . '/../../helper/helper.php')) {
            include __DIR__ . '/../../helper/helper.php';
        }

        $this->publishes([
            __DIR__.'/../../publishes/resources' => resource_path(),
        ], 'resource');
        
        $this->publishes([
            __DIR__.'/../../publishes/database/migrations' => database_path('migrations'),
        ], 'migration');

        $this->registerPolices();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        \Module::registerFromJsonFile('user', __DIR__ .'/../../module.json');
        \Menu::registerType('Trang tĩnh', \Packages\Page\Page::class);
        $this->registerAdminMenu();
    }

    private function registerPolices()
    {
        \AccessControl::define(trans('page.page') .' - '.trans('page.add-new-page'), 'admin.page.create');
        \AccessControl::define(trans('page.page') .' - '.trans('page.list-page'), 'admin.page.index');
        \AccessControl::define(trans('page.page') .' - '.trans('page.disable-page'), 'admin.page.disable');
        \AccessControl::define(trans('page.page') .' - '.trans('page.enable-page'), 'admin.page.enable');
        \AccessControl::define(trans('page.page') .' - '.trans('page.edit-page'), 'admin.page.edit');
        \AccessControl::define(trans('page.page') .' - '.trans('page.destroy-page'), 'admin.page.destroy');
    }

    private function registerAdminMenu()
    {
        add_action('admin.init', function () {
            if (\Auth::user()->can('admin.page.index')) {
                \AdminMenu::register('page', [
                    'parent' => 'main-manage',
                    'label' => trans('page.page'),
                    'icon' => 'icon-docs',
                    'url'   => route('admin.page.index'),
                    'order' => '2',
                ]);
            }

            if (\Auth::user()->can('admin.page.create')) {
                \AdminMenu::register('page.create', [
                    'parent' => 'page',
                    'label' => trans('page.add-new-page'),
                    'icon' => 'icon-note',
                    'url'   => route('admin.page.create'),
                ]);
            }

            if (\Auth::user()->can('admin.page.index')) {
                \AdminMenu::register('page.index', [
                    'parent' => 'page',
                    'label' => trans('page.list-page'),
                    'icon' => 'icon-list',
                    'url'   => route('admin.page.index'),
                ]);
            }
        });
    }
}
