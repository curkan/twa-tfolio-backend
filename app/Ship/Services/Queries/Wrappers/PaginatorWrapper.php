<?php

declare(strict_types=1);

namespace App\Ship\Services\Queries\Wrappers;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;

class PaginatorWrapper
{
    /**
     * @param Builder|EloquentBuilder $query
     * @param int|null $perPage
     *
     * @return LengthAwarePaginator
     */
    public function paginate(Builder|EloquentBuilder $query, ?int $perPage = null): LengthAwarePaginator
    {
        return $query->paginate(per_page_normalize($perPage));
    }

    /**
     * @param Builder|EloquentBuilder $query
     *
     * @return Collection|LengthAwarePaginator|Paginator
     */
    public function paginateOrAll(Builder|EloquentBuilder $query): Collection|LengthAwarePaginator|Paginator
    {
        if ($query instanceof Paginator) {
            return $query;
        }

        if ($this->hasPagination()) {
            return $this->paginate($query, (int) request()->query('per_page'));
        }

        return $query->get();
    }

    /**
     * @param Builder|EloquentBuilder $query
     * @param int|null $limit
     *
     * @return Collection|LengthAwarePaginator|Paginator
     */
    public function paginateOrLimit(Builder|EloquentBuilder $query, ?int $limit = null): Collection|LengthAwarePaginator|Paginator
    {
        if ($query instanceof Paginator) {
            return $query;
        }

        if ($this->hasPagination()) {
            return $this->paginate($query, (int) request()->query('per_page'));
        }

        $limit = $limit ?: config('app.collection_max_size');
        if (!empty($query->limit) && $query->limit <= $limit) {
            return $query->get();
        }

        return $query
            ->limit($limit)
            ->get();
    }

    /**
     * @return bool
     */
    private function hasPagination(): bool
    {
        return request()->query->has('by_page') || (int) request()->query('per_page') > 0;
    }
}
