<?php

declare(strict_types=1);

namespace App\Ship\Parents\Enums;

trait EnumExtention
{
    /**
     * @return array
     */
    public static function getKeys(): array
    {
        return array_column(self::cases(), 'name'); /* @phpstan-ignore-line */
    }

    /**
     * @return array
     */
    public static function getValues(): array
    {
        return array_column(self::cases(), 'value'); /* @phpstan-ignore-line */
    }

    /**
     * @return array
     */
    public static function toArray(): array
    {
        return array_combine(self::getKeys(), self::getValues()); /* @phpstan-ignore-line */
    }
}
