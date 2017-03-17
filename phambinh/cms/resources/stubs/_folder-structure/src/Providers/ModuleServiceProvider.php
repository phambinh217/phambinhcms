<?php
/**
 * ModuleAlias: DummyAlias
 * ModuleName: DummyName
 * Description: This is the first file run of module. You can assign bootstrap or register module Services
 * @author: DummyAuthor
 * @version: DummyVersion
 * @package: PackagesCMS
 */
namespace DummyNamespace\Providers;

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
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'DummyUcfirst');

        // Load translations
        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', 'DummyUcfirst');

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
        \Module::registerFromComposerJson(__DIR__.'/../..');
        $this->registerAdminMenu();
    }

    private function registerPolices()
    {
        //
    }

    private function registerAdminMenu()
    {
        add_action('admin.init', function () {
        });
    }
}
