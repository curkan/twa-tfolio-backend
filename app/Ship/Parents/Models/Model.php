<?php

declare(strict_types=1);

namespace App\Ship\Parents\Models;

use App\Ship\Core\Abstracts\Models\Model as AbstractModel;
use App\Ship\Core\Traits\FactoryLocatorTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class: Model.
 *
 * @see AbstractModel
 * @abstract
 */
abstract class Model extends AbstractModel
{
    use FactoryLocatorTrait, HasFactory {
        FactoryLocatorTrait::newFactory insteadof HasFactory;
    }

    protected function asJson($value)
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }
}
