<?php

declare(strict_types=1);

namespace App\Ship\Services\Traits\Tasks;

trait AsTask
{
    /**
     * @return static
     */
    public static function make(): static
    {
        return app(static::class);
    }

    /**
     * @param mixed ...$arguments
     *
     * @return mixed
     */
    public static function run(...$arguments): mixed
    {
        return static::make()->handle(...$arguments);
    }
}
