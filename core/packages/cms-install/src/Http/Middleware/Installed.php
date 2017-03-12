<?php

namespace Packages\CmsInstall\Http\Middleware;

use \Closure;

class Installed
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  array|string $role
     * @return mixed
     */
    public function handle($request, Closure $next, ...$params)
    {
        if (!env('INSTALLED') && \Route::has('install.index')) {
            return redirect()->route('install.index');
        }

        return $next($request);
    }
}
