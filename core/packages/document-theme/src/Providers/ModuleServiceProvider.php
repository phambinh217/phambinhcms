<?php
/**
 * ModuleAlias: document-theme
 * ModuleName: document-theme
 * Description: This is the first file run of module. You can assign bootstrap or register module Services
 * @author: noname
 * @version: 1.0
 * @package: PackagesCMS
 */
namespace Packages\DocumentTheme\Providers;

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
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'DocumentTheme');

        // Load translations
        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', 'DocumentTheme');

        // Load helper
        if (\File::exists(__DIR__ . '/../../helper/helper.php')) {
            include __DIR__ . '/../../helper/helper.php';
        }

        // $this->publishes([
        //     __DIR__.'/../../publishes/database/migrations' => database_path('migrations'),
        // ], 'migration');

        $this->registerPolices();
    }

    /**
     * Register the application Services.
     *
     * @return void
     */
    public function register()
    {
        \Module::registerFromJsonFile('document-theme', __DIR__ .'/../../theme.json');
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
