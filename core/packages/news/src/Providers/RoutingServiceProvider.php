<?php 

namespace Packages\News\Providers;

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

        Route::pattern('news', '[0-9]+');
        Route::pattern('category', '[0-9]+');

        if (!$this->app->routesAreCached()) {
            if (\File::exists(__DIR__ . '/../../routes/web.php')) {
                $this->loadRoutesFrom(__DIR__ . '/../../routes/web.php');
            }

            if (\File::exists(__DIR__ . '/../../routes/api.php')) {
                $this->loadRoutesFrom(__DIR__ . '/../../routes/api.php');
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
