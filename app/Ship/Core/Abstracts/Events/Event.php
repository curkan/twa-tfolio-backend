<?php

declare(strict_types=1);

namespace App\Ship\Core\Abstracts\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Class: Event.
 *
 * @abstract
 */
abstract class Event
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;
}
