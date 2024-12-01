<?php

declare(strict_types=1);

namespace App\Ship\Parents\Enums\ConsumerPurchase;

use BenSampo\Enum\Enum;

final class ConsumerPurchaseStatus extends Enum
{
    public const Init = 'init';
    public const Issued = 'issued';
}
