<?php

declare(strict_types=1);

namespace App\Ship\Services\Externals\Contracts;

use Illuminate\Http\Client\Response;

interface ResponseContract
{
    /**
     * @return Response
     */
    public function response(): Response;

    /**
     * @return bool
     */
    public function successful(): bool;

    /**
     * @return bool
     */
    public function failed(): bool;

    /**
     * @return mixed
     */
    public function data(): mixed;

    /**
     * @return array
     */
    public function errors(): array;

    /**
     * @return string
     */
    public function body(): string;

    /**
     * @return bool
     */
    public function isJson(): bool;

    /**
     * @return bool
     */
    public function isStream(): bool;

    /**
     * @return bool
     */
    public function isHtml(): bool;

    /**
     * @return bool
     */
    public function isXml(): bool;

    /**
     * @return bool
     */
    public function isText(): bool;
}
