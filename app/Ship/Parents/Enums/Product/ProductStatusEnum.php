<?php

declare(strict_types=1);

namespace App\Ship\Parents\Enums\Product;

use BenSampo\Enum\Enum;

final class ProductStatusEnum extends Enum
{
    public const Published = 'published';
    public const Unpublished = 'unpublished';
}
