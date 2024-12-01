<?php

declare(strict_types=1);

namespace App\Ship\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Support\Collection;

/* Need for write to database */
final class AsCollectionWithUnescapedUnicode implements CastsAttributes
{
    /**
     * @param $model
     * @param $key
     * @param $value
     * @param $attributes
     *
     * @return Collection|null
     */
    public function get($model, $key, $value, $attributes): ?Collection
    {
        return isset($attributes[$key]) ? new Collection(json_decode($attributes[$key], true)) : null;
    }

    /**
     * @param $model
     * @param $key
     * @param $value
     * @param $attributes
     *
     * @return array
     */
    public function set($model, $key, $value, $attributes)
    {
        return [$key => json_encode($value, JSON_UNESCAPED_UNICODE)];
    }
}
