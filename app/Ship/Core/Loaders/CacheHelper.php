<?php

declare(strict_types=1);

namespace App\Ship\Core\Loaders;

class CacheHelper
{
    private string $cacheDir;

    /**
     * @return void
     */
    public function __construct()
    {
        $dir = base_path('storage');
        $this->cacheDir = $dir . '/framework/cache/porto/';
    }

    /**
     * @param string $key
     *
     * @return bool|string|null
     */
    public function get(string $key): null|bool|string
    {
        $filePath = $this->getFilePath($key);

        if (file_exists($filePath)) {
            return file_get_contents($filePath);
        }

        return null;
    }

    /**
     * @param string $key
     * @param string $value
     *
     * @return void
     */
    public function set(string $key, string $value): void
    {
        $filePath = $this->getFilePath($key);

        if (!is_dir($this->cacheDir)) {
            mkdir($this->cacheDir);
        }

        file_put_contents($filePath, $value);
    }

    /**
     * @param string $key
     *
     * @return void
     */
    public function delete(string $key): void
    {
        $filePath = $this->getFilePath($key);

        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }

    /**
     * @param string $key
     *
     * @return string
     */
    private function getFilePath(string $key): string
    {
        return $this->cacheDir . md5($key) . '.json';
    }
}
