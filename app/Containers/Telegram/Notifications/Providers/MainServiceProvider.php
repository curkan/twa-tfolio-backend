<?php

declare(strict_types=1);

namespace App\Containers\Telegram\Notifications\Providers;

use App\Ship\Parents\Providers\MainServiceProvider as ParentMainServiceProvider;

/**
 * Class MainServiceProvider.
 *
 * The Main Service Provider of this container, it will be automatically registered in the framework.
 */
class MainServiceProvider extends ParentMainServiceProvider
{
    /**
     * Container Service Providers.
     */
    public array $serviceProviders = [
        EventServiceProvider::class,
    ];

    /**
     * Container Aliases.
     */
    public array $aliases = [

    ];
}
