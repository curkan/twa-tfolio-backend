<?php

declare(strict_types=1);

namespace App\Ship\Services\Generators;

use Exception;
use Illuminate\Support\Facades\Cache;

/**
 * Class CodeProcessor.
 */
class NumberCodeGenerator
{
    /**
     * Prefix for cache keys.
     * @var string
     */
    private $cachePrefix = '';

    /**
     * Code length.
     * @var int
     */
    private $codeLength = 6;

    /**
     * Lifetime of codes in seconds.
     * @var int
     */
    private $secondsLifetime = 1;

    /**
     * @param string $tag
     * @param mixed $value
     *
     * @return int
     */
    public function generateCode(string $tag, mixed $value): int
    {
        try {
            $randomFunction = 'random_int';

            if (!function_exists($randomFunction)) {
                $randomFunction = 'mt_rand';
            }

            $code = $randomFunction(10**($this->codeLength - 1), 10** $this->codeLength - 1);

            Cache::put($this->makeCacheKey($tag, $code), $value, now()->addSeconds($this->secondsLifetime));
        } catch (Exception $e) {
            throw new Exception('Code generation failed', 0, $e);
        }

        return $code;
    }

    /**
     * @param string $tag
     * @param int $code
     * @param mixed $value
     *
     * @return bool
     */
    public function validateCode(string $tag, int|string $code, mixed $value): bool
    {
        $codeValue = Cache::get($this->makeCacheKey($tag, $code));

        if (null === $codeValue) {
            Cache::forget($this->makeCacheKey($tag, $code));

            return false;
        }

        if ($codeValue !== $value) {
            return false;
        }

        Cache::forget($this->makeCacheKey($tag, $code));

        return true;
    }

    /**
     * @param int $seconds
     *
     * @return self
     */
    public function setLifetime(int $seconds): self
    {
        $this->secondsLifetime = $seconds;

        return $this;
    }

    /**
     * @return int Seconds
     */
    public function getLifetime()
    {
        return $this->secondsLifetime;
    }

    /**
     * @param string $tag
     * @param int $code
     *
     * @return string
     */
    private function makeCacheKey(string $tag, int|string $code): string
    {
        return $this->cachePrefix . '.' . $tag . '.' . (string) $code;
    }
}
