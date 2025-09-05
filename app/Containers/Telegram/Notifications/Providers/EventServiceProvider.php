<?php

declare(strict_types=1);

namespace App\Containers\Telegram\Notifications\Providers;

use App\Containers\Common\Node\UI\Api\Events\NodeLiked;
use App\Containers\Telegram\Notifications\Listeners\LikeNodeListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ParentEventServiceProvider;

class EventServiceProvider extends ParentEventServiceProvider
{
    protected $listen = [
        NodeLiked::class => [
            LikeNodeListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return true;
    }
}
