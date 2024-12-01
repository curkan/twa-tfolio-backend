<?php

declare(strict_types=1);

namespace App\Ship\Parents\Providers;

use App\Ship\Core\Abstracts\Providers\MainServiceProvider as AbstractMainServiceProvider;

/**
 * Class MainServiceProvider.
 *
 * A.K.A. app/Providers/AppServiceProvider.php
 */
abstract class MainServiceProvider extends AbstractMainServiceProvider
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
