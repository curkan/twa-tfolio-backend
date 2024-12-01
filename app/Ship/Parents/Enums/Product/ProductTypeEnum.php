<?php

declare(strict_types=1);

namespace App\Ship\Parents\Enums\Product;

use BenSampo\Enum\Enum;

final class ProductTypeEnum extends Enum
{
    public const Digital = 'digital';
    public const Tutorial = 'tutorial';
    public const Music = 'music';
}
