<?php

namespace Packages\Ecommerce\Providers;

use Illuminate\Support\Facades\Route;
use App\Providers\RouteServiceProvider as ServiceProvider;

class RoutingServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     * Include helper file in helpers folder
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Route::pattern('product', '[0-9]+');
        Route::pattern('category', '[0-9]+');
        Route::pattern('brand', '[0-9]+');
        Route::pattern('filter', '[0-9]+');
        Route::pattern('attribute', '[0-9]+');
        Route::pattern('option', '[0-9]+');
        Route::pattern('tag', '[0-9]+');
        Route::pattern('currency', '[0-9]+');
        Route::pattern('{customer}', '[0-9]+');

        if (!$this->app->routesAreCached()) {
            if (\File::exists(__DIR__ . '/../../routes/web.php')) {
                include __DIR__ . '/../../routes/web.php';
            }

            if (\File::exists(__DIR__ . '/../../routes/api.php')) {
                include __DIR__ . '/../../routes/api.php';
            }

            if (\File::exists(__DIR__ . '/../../routes/console.php')) {
                include __DIR__ . '/../../routes/console.php';
            }
        }
    }

    /**
     * Register application services
     * @return void
     */
    public function register()
    {
        //
    }
}
