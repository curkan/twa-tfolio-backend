<?php

declare(strict_types=1);

namespace App\Ship\Providers;

use App\Ship\Parents\Models\Node;
use App\Ship\Parents\Policies\NodePolicy;
use App\Ship\Parents\Providers\AuthServiceProvider as ProvidersAuthServiceProvider;

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
        Node::class => NodePolicy::class,
    ];

    /**
     * @return void
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
