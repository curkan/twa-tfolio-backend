<?php

declare(strict_types=1);

namespace App\Ship\Parents\Providers;

use App\Ship\Core\Abstracts\Providers\RepositoryServiceProvider as AbstractRepositoryServiceProvider;

/**
 * Class: RouteServiceProvider.
 *
 * @see AbstractRouteServiceProvider
 * @abstract
 */
abstract class RepositoryServiceProvider extends AbstractRepositoryServiceProvider
{
    /**
     * Perform post-registration booting of services.
     */
    public function boot(): void
    {
        parent::boot();
    }

    /**
     * Register anything in the container.
     */
    public function register(): void
    {
        parent::register();
    }
}
