<?php

namespace Packages\CmsInstall\Providers;

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

        if (!env('INSTALLED')) {
            if (!$this->app->routesAreCached()) {
                if (\File::exists(__DIR__ . '/../../routes/web.php')) {
                    include __DIR__ . '/../../routes/web.php';
                }
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
