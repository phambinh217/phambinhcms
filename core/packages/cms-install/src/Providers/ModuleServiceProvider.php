<?php
/**
 * ModuleAlias: install
 * ModuleName: install
 * Description: This is the first file run of module. You can assign bootstrap or register module Services
 * @author: noname
 * @version: 1.0
 * @package: PackagesCMS
 */
namespace Packages\CmsInstall\Providers;

use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application Services.
     *
     * @return void
     */
    public function boot()
    {
        // Load views
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'Install');

        // Load translations
        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', 'Install');

        // Load helper
        if (\File::exists(__DIR__ . '/../../helper/helper.php')) {
            include __DIR__ . '/../../helper/helper.php';
        }

        $this->registerPolices();
    }

    /**
     * Register the application Services.
     *
     * @return void
     */
    public function register()
    {
        \Module::registerFromJsonFile('install', __DIR__ .'/../../module.json');
        $this->registerAdminMenu();
    }

    private function registerPolices()
    {
        //
    }

    private function registerAdminMenu()
    {
        //
    }
}
