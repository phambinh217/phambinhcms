<?php 

namespace Phambinh\Cms\Providers;

use Illuminate\Support\Facades\Route;
use App\Providers\RouteServiceProvider as ServiceProvider;

class RoutingServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application Services.
     * Include helper file in helpers folder
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Route::pattern('id', '[0-9]+');
        Route::pattern('any', '[^/]+');
        Route::pattern('*', '(.+)');
        Route::pattern('user', '[0-9]+');
        Route::pattern('role', '[0-9]+');
        
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
     * Register application Services
     * @return void
     */
    public function register()
    {
        //
    }
}
