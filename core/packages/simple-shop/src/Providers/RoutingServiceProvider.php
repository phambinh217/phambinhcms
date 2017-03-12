<?php 

namespace Packages\SimpleShop\Providers;

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

        if (!$this->app->routesAreCached()) {
            if (\File::exists(__DIR__ . '/../../routes/web.php')) {
                include __DIR__ . '/../../routes/web.php';
            }

            if (\File::exists(__DIR__ . '/../../routes/console.php')) {
                include __DIR__ . '/../../routes/console.php';
            }

            if (\File::exists(__DIR__ . '/../../routes/api.php')) {
                include __DIR__ . '/../../routes/api.php';
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
