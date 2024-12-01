<?php

declare(strict_types=1);

namespace App\Ship\Services\Externals\Clients;

use App\Ship\Services\Enums\HttpMethods;
use App\Ship\Services\Externals\Contracts\ResponseContract;
use App\Ship\Services\Externals\Exceptions\ExternalServiceException;
use App\Ship\Services\Externals\Responses\ExternalResponse;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

abstract class AbstractClient
{
    /**
     * @var string
     */
    protected string $responseWrapper = ExternalResponse::class;

    /**
     * @return array
     */
    abstract public function params(): array;

    /**
     * @return string
     */
    abstract public function method(): string;

    /**
     * @return string
     */
    abstract public function url(): string;

    /**
     * @param string $path
     * @param array $params
     *
     * @return Response
     */
    public function postAsJson(string $path, ?array $params = []): Response
    {
        return Http::asJson()->withoutVerifying()->post($path, $params);
    }

    /**
     * @param string $path
     * @param array $params
     *
     * @return Response
     */
    public function getAsJson(string $path, ?array $params = []): Response
    {
        return Http::asJson()->withoutVerifying()->get($path, $params);
    }

    /**
     * @return ResponseContract
     */
    public function send(): ResponseContract
    {
        $response = null;

        match ($this->method()) {
            HttpMethods::METHOD_GET => $response = $this->wrapResponse($this->getAsJson($this->url(), $this->params())),
            HttpMethods::METHOD_POST => $response = $this->wrapResponse($this->postAsJson($this->url(), $this->params())),
            default => $response = $this->wrapResponse($this->getAsJson($this->url(), $this->params())),
        };

        return $response;
    }

    /**
     * @return string
     */
    protected function responseWrapper(): string
    {
        return $this->responseWrapper;
    }

    /**
     * @param ResponseContract $response
     * @throws ExternalServiceException
     */
    protected function validateResponse(ResponseContract $response): void
    {
        if (!$response->successful()) {
            report(new RequestException($response->response()));
            $this->handleErrors($response->errors() ?: Arr::wrap($response->data()));
        }
    }

    /**
     * @param array $errors
     * @throws ExternalServiceException
     */
    protected function handleErrors(array $errors): void
    {
        throw new ExternalServiceException($errors ?: 'Unknown error');
    }

    /**
     * @param Response $response
     *
     * @return ResponseContract
     */
    protected function wrapResponse(Response $response): ResponseContract
    {
        $response = call_user_func([$this->responseWrapper(), 'from'], $response);

        $this->validateResponse($response);

        return $response;
    }
}
