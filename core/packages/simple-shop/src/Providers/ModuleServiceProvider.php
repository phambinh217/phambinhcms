<?php
/**
 * ModuleAlias: baseshop
 * ModuleName: baseshop
 * Description: This is the first file run of module. You can assign bootstrap or register module services
 * @author: noname
 * @version: 1.0
 * @package: PackagesCMS
 */
namespace Packages\SimpleShop\Providers;

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
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'Home');

        // Load translations
        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', 'Home');

        // Load migrations
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');

        // Merge configs
        if (\File::exists(__DIR__ . '/../../config/config.php')) {
            $this->mergeConfigFrom(__DIR__ . '/../../config/config.php', 'baseshop');
        }

        // Load helper
        if (\File::exists(__DIR__ . '/../../helper/helper.php')) {
            include __DIR__ . '/../../helper/helper.php';
        }

        $this->publishes([
            __DIR__.'/../../assets' => public_path('assets'),
        ], 'public');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        \Module::registerFromJsonFile('shop', __DIR__ .'/../../theme.json');
        \Menu::registerLocation([
            'id' => 'master-menu',
            'name' => 'Master menu',
        ]);

        \Menu::registerLocation([
            'id' => 'master-menu-2',
            'name' => 'Master menu 2',
        ]);
    }
}
