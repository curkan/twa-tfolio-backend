<?php

declare(strict_types=1);

namespace App\Ship\Services\Facades;

use App\Ship\Services\Generators\NumberCodeGenerator;
use Illuminate\Support\Facades\Facade;

/**
 * @method static int generateCode(string $tag, mixed $value)
 * @method static bool validateCode(string $tag, string|int $code, mixed $value)
 * @method static self setLifetime(int $seconds)
 */
class NumberCode extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return NumberCodeGenerator::class;
    }
}
