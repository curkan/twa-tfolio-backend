<?php

declare(strict_types=1);

namespace App\Ship\Services\Storages;

/**
 * @see AbstractStorage
 */
final class YandexImagesStorage extends AbstractStorage
{
    /**
     * @return string
     */
    protected function disk(): string
    {
        return 's3_images';
    }
}
