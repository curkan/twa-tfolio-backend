<?php

declare(strict_types=1);

namespace App\Ship\Services\Storages;

/**
 * @see AbstractStorage
 */
final class YandexVideosStorage extends AbstractStorage
{
    /**
     * @return string
     */
    protected function disk(): string
    {
        return 's3_videos';
    }
}
