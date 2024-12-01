<?php

declare(strict_types=1);

namespace App\Ship\Services\Traits\Commands;

use Illuminate\Console\Concerns\HasParameters;
use Illuminate\Console\Concerns\InteractsWithIO;
use Validator;

trait ValidateInputs
{
    use HasParameters;
    use InteractsWithIO;

    /**
     * @param ?array $argumentRules
     * @param ?array $optionRules
     *
     * @return array
     */
    public function validate(?array $argumentRules = null, ?array $optionRules = null): array
    {
        $arguments = $argumentRules
            ? $this->validateArguments($this->arguments(), $argumentRules)
            : $this->arguments();

        $options = $optionRules
            ? $this->validateOptions($this->options(), $optionRules)
            : $this->options();

        return [$arguments, $options];
    }

    /**
     * @param array $options
     * @param array $rules
     *
     * @return ?array
     */
    protected function validateOptions(array $options = [], array $rules = []): ?array
    {
        $validator = Validator::make($options, $rules);

        if ($validator->fails()) {
            $this->error('Whoops! The given options are invalid.');

            collect($validator->errors()->all())
                ->each(fn ($error) => $this->line($error));

            exit;
        }

        return $validator->validated();
    }

    /**
     * @param array $arguments
     * @param array $rules
     *
     * @return ?array
     */
    protected function validateArguments(array $arguments = [], array $rules = []): ?array
    {
        $validator = Validator::make($arguments, $rules);

        if ($validator->fails()) {
            $this->error('Whoops! The given attributes are invalid.');

            collect($validator->errors()->all())
                ->each(fn ($error) => $this->line($error));

            exit;
        }

        return $validator->validated();
    }
}
