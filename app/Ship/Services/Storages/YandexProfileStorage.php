<?php

declare(strict_types=1);

namespace App\Ship\Services\Storages;

/**
 * @see AbstractStorage
 */
final class YandexProfileStorage extends AbstractStorage
{
    /**
     * @return string
     */
    protected function disk(): string
    {
        return 'yandex_profiles';
    }
}
