<?php

declare(strict_types=1);

namespace App\Ship\Services\Queries;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

abstract class AbstractQuery
{
    /**
     * @param mixed ...$parameters
     * @return Builder|EloquentBuilder
     */
    public static function make(...$parameters): Builder|EloquentBuilder
    {
        return app(static::class)(...$parameters);
    }

    /**
     * @param string $table
     * @return Builder
     */
    protected function table(string $table): Builder
    {
        return DB::table($table);
    }

    /**
     * @param Model|string $model
     * @return EloquentBuilder
     */
    protected function model(Model|string $model): EloquentBuilder
    {
        return $model::query();
    }
}
