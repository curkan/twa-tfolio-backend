<?php

declare(strict_types=1);

namespace App\Ship\Parents\Exceptions;

use App\Ship\Services\Common\ContextMessage;
use App\Ship\Services\Responses\Messages;
use App\Ship\Services\Responses\Responses;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Throwable;

class BusinessLogicException extends Exception
{
    /**
     * @var array
     */
    protected array $errors = [];

    /**
     * @var string
     */
    protected $message = Messages::ERROR_HAS_OCCURRED;

    /**
     * @var int
     */
    protected $code = ResponseAlias::HTTP_UNPROCESSABLE_ENTITY;

    /**
     * @param array<ContextMessage|string>|ContextMessage|string|null $errors
     * @param string|null $message
     * @param int|null $code
     * @param Throwable|null $previous
     */
    public function __construct(
        null|array|ContextMessage|string $errors = null,
        ?string $message = null,
        ?int $code = null,
        ?Throwable $previous = null
    ) {
        $this->errors = Arr::wrap($errors);
        $message = $message ?: $this->message;
        $code = $code ?: $this->code;

        parent::__construct($message, $code, $previous);
    }

    /**
     * @param array<ContextMessage|string>|ContextMessage|string|null $errors
     * @param string|null $message
     * @param int|null $code
     * @param Throwable|null $previous
     * @return static
     */
    public static function make(
        null|array|ContextMessage|string $errors = null,
        ?string $message = null,
        ?int $code = null,
        ?Throwable $previous = null
    ): static {
        return new static($errors, $message, $code, $previous); /* @phpstan-ignore-line */
    }

    /**
     * @return array
     */
    public function errors(): array
    {
        return $this->errors;
    }

    /**
     * @return JsonResponse
     */
    public function toResponse(): JsonResponse
    {
        $errors = array_map(
            fn ($error) => $error instanceof ContextMessage ? $error->toArray() : $error,
            $this->errors
        );

        return Responses::error($errors, $this->getMessage(), $this->getCode());
    }
}
