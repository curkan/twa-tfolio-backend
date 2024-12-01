<?php

declare(strict_types=1);

namespace App\Ship\Parents\Enums\ProductNode;

use BenSampo\Enum\Enum;

final class ProductNodeTypeEnum extends Enum
{
    public const File = 'file';
    public const Folder = 'folder';
}
