<?php

declare(strict_types=1);

namespace App\Ship\Parents\Enums\Nodes;

use App\Ship\Parents\Enums\EnumExtention;

enum NodeTypeEnum: string
{
    use EnumExtention;

    case Image = 'image';
}
