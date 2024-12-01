<?php

declare(strict_types=1);

namespace App\Ship\Services\Rules;

use App\Ship\Services\Common\ContextMessage;
use App\Ship\Services\Traits\Exceptions\ContextMessageSerializer;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

final class In implements ValidationRule
{
    use ContextMessageSerializer;

    /**
     * @var array
     */
    private array $values;

    /**
     * @param mixed ...$values
     */
    public function __construct(...$values)
    {
        $this->values = $values;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!in_array($value, $this->values)) {
            $fail($this->serializeContextMessage(ContextMessage::make(
                'The selected value is invalid. Available: {{values}}',
                ['values' => implode(',', $this->values)]
            )));
        }
    }
}
