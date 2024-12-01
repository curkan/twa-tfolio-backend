<?php

declare(strict_types=1);

namespace App\Ship\Core\Abstracts\Notifications;

use Illuminate\Notifications\Notification as LaravelNotification;
use Illuminate\Support\Facades\Config;

/**
 * Class: Notification.
 *
 * @see LaravelNotification
 * @abstract
 */
abstract class Notification extends LaravelNotification
{
    /**
     * @return array
     */
    public function via(): array
    {
        return Config::get('notification.channels');
    }
}
