<?php

declare(strict_types=1);

namespace App\Ship\Core\Abstracts\Providers;

use App\Ship\Core\Loaders\RoutesLoaderTrait;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as LaravelRouteServiceProvider;

abstract class RouteServiceProvider extends LaravelRouteServiceProvider
{
    use RoutesLoaderTrait;

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot(): void
    {
        //        $this->routes(function () {
        //            Route::middleware('api')
        //                ->prefix('api')
        //                ->group(base_path('routes/api.php'));
        //
        //            Route::middleware('web')
        //                ->group(base_path('routes/web.php'));
        //        });
    }

    /**
     * Define the routes for the application.
     */
    public function map(): void
    {
        $this->runRoutesAutoLoader();
    }
}
