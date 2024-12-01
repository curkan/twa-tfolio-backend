<?php

declare(strict_types=1);

namespace App\Ship\Services\Traits\Requests\Validation;

trait HasPagination
{
    /**
     * @param int|null $perPage
     *
     * @return string[]
     */
    protected function paginationRules(?int $perPage = null): array
    {
        $perPage = $perPage ?: config('app.pagination_max_page_size');

        return [
            'per_page' => 'sometimes|integer|between:1,' . $perPage,
            'by_page' => 'sometimes',
            'page' => 'sometimes|integer',
        ];
    }
}
