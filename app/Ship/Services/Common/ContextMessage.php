<?php

declare(strict_types=1);

namespace App\Ship\Services\Common;

use Illuminate\Support\Str;

class ContextMessage
{
    /**
     * @var string
     */
    private string $message;

    /**
     * @var array
     */
    private array $context;

    /**
     * @param string $message
     * @param array $context
     */
    public function __construct(string $message, array $context = [])
    {
        $this->message = $message;
        $this->context = $context;
    }

    /**
     * @param string $message
     * @param array $context
     * @return self
     */
    public static function make(string $message, array $context = []): self
    {
        return new self($message, $context);
    }

    /**
     * @return string
     */
    public function message(): string
    {
        return $this->message;
    }

    /**
     * @return array
     */
    public function context(): array
    {
        return $this->context;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'message' => $this->message,
            'context' => $this->context,
        ];
    }

    /**
     * @return string
     */
    protected function toString(): string
    {
        $search = array_map(fn ($key) => '{{' . $key . '}}', array_keys($this->context));

        return Str::replace($search, array_values($this->context), $this->message);
    }
}
