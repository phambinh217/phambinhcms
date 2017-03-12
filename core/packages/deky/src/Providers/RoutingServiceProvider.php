<?php

namespace Packages\Deky\Providers;

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

        Route::pattern('category', '[0-9]+');
        Route::pattern('course', '[0-9]+');
        Route::pattern('student', '[0-9]+');
        Route::pattern('student_group', '[0-9]+');
        Route::pattern('class1', '[0-9]+');
        Route::pattern('trainer', '[0-9]+');
        Route::pattern('partner', '[0-9]+');

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
