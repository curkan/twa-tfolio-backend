<?php

declare(strict_types=1);

namespace App\Ship\Providers;

use App\Ship\Parents\Providers\AuthServiceProvider as ProvidersAuthServiceProvider;
use Illuminate\Support\Facades\Gate;

/**
 * Class: AuthServiceProvider.
 *
 * @see ProvidersAuthServiceProvider
 * @final
 */
final class AuthServiceProvider extends ProvidersAuthServiceProvider
{
    /**
     * The policy mappings for the application.
     */
    protected $policies = [

    ];

    public function boot(): void
    {
        Gate::before(function ($user, $ability) {
            return true;
        });

        $this->registerPolicies();
    }
}
