<?php

declare(strict_types=1);

namespace App\Ship\Core\Abstracts\Providers;

use App\Ship\Core\Loaders\RepositoryLoaderTrait;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as LaravelRouteServiceProvider;

abstract class RepositoryServiceProvider extends LaravelRouteServiceProvider
{
    use RepositoryLoaderTrait;

    /**
     * @return void
     */
    public function boot(): void {}

    /**
     * Define the routes for the application.
     */
    public function map(): void
    {
        $this->runRepositoryAutoLoader();
    }
}
