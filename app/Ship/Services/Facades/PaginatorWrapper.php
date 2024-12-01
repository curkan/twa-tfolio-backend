<?php

declare(strict_types=1);

namespace App\Ship\Services\Facades;

use App\Ship\Services\Queries\Wrappers\PaginatorWrapper as WrappersPaginatorWrapper;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;

/**
 * @method static LengthAwarePaginator paginate(Builder|EloquentBuilder $query, ?int $perPage = null)
 * @method static LengthAwarePaginator|Collection|Paginator paginateOrAll(Builder|EloquentBuilder $query)
 * @method static LengthAwarePaginator|Collection|Paginator paginateOrLimit(?Builder $query = null, ?int $limit = null)
 *
 * @see PaginatorWrapper
 */
class PaginatorWrapper extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return WrappersPaginatorWrapper::class;
    }
}
