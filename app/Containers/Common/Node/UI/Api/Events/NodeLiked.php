<?php

declare(strict_types=1);

namespace App\Containers\Common\Node\UI\Api\Events;

use App\Ship\Parents\Events\Event;
use App\Ship\Parents\Models\NodeLikes;
use Illuminate\Foundation\Events\Dispatchable;

class NodeLiked extends Event
{
    use Dispatchable;

    public function __construct(
        public NodeLikes $nodeLike,
    ) {}
}
