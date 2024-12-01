<?php

declare(strict_types=1);

namespace App\Ship\Parents\Enums\User;

use BenSampo\Enum\Enum;

final class UserStatusEnum extends Enum
{
    public const Active = 1;
    public const Blocked = 0;
}
