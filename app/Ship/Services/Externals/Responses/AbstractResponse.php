<?php

declare(strict_types=1);

namespace App\Ship\Services\Externals\Responses;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Arr;

abstract class AbstractResponse
{
    /**
     * @var Response
     */
    protected Response $response;

    /**
     * @var mixed
     */
    protected mixed $data;

    /**
     * @var array
     */
    protected array $errors;

    /**
     * @param Response $response
     */
    public function __construct(Response $response)
    {
        $this->response = $response;

        $this->setUp();
    }

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->data = match (true) {
            $this->isJson() => $this->response->json(),
            default => $this->response->body(),
        };

        $this->errors = match (true) {
            $this->isJson() => (array) Arr::get((array) $this->data, 'errors', []),
            default => [],
        };
    }

    /**
     * @param Response $response
     *
     * @return static
     */
    public static function from(Response $response): static
    {
        return new static($response); /* @phpstan-ignore-line */
    }

    /**
     * @return bool
     */
    public function successful(): bool
    {
        return $this->response->successful() && empty($this->errors);
    }

    /**
     * @return bool
     */
    public function failed(): bool
    {
        return !$this->successful();
    }

    /**
     * @return string
     */
    public function body(): string
    {
        return $this->response->body();
    }

    /**
     * @return array
     */
    public function errors(): array
    {
        return $this->errors;
    }

    /**
     * @return mixed
     */
    public function data(): mixed
    {
        return $this->data;
    }

    /**
     * @return Response
     */
    public function response(): Response
    {
        return $this->response;
    }

    /**
     * @return bool
     */
    public function isJson(): bool
    {
        return $this->response->header('Content-Type') === 'application/json' || json_validate($this->response->body());
    }

    /**
     * @return bool
     */
    public function isStream(): bool
    {
        return $this->response->header('Content-Type') === 'application/octet-stream';
    }

    /**
     * @return bool
     */
    public function isHtml(): bool
    {
        return $this->response->header('Content-Type') === 'text/html';
    }

    /**
     * @return bool
     */
    public function isXml(): bool
    {
        return $this->response->header('Content-Type') === 'text/xml';
    }

    /**
     * @return bool
     */
    public function isText(): bool
    {
        return $this->response->header('Content-Type') === 'text/plain';
    }
}
