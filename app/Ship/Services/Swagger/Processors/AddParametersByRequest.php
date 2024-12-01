<?php

declare(strict_types=1);

namespace App\Ship\Services\Swagger\Processors;

use App\Ship\Services\Traits\Requests\Validation;
use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Analysis;
use OpenApi\Annotations\Operation;
use OpenApi\Annotations\Parameter;
use OpenApi\Generator;
use OpenApi\Processors\ProcessorInterface;
use ReflectionClass;
use ReflectionException;

final class AddParametersByRequest implements ProcessorInterface
{
    private const ALLOWED_METHODS = [
        'index',
        '__invoke',
    ];

    private const TRAIT_PARAMETERS = [
        Validation\HasPagination::class => [
            [
                'options' => [
                    'name' => 'per_page',
                    'description' => 'number of entries per page',
                ],
            ],
            [
                'options' => [
                    'name' => 'page',
                    'description' => 'current page from which you want to get data',
                ],
            ],
        ],
    ];

    /**
     * @param Analysis $analysis
     *
     * @return void
     */
    public function __invoke(Analysis $analysis): void
    {
        /** @var list<Operation> $operations */
        $operations = $analysis->getAnnotationsOfType(Operation::class);

        foreach ($operations as $operation) {
            foreach (self::TRAIT_PARAMETERS as $trait => $parameters) {
                if ($requestClass = $this->getFormRequest($operation, $trait)) {
                    $this->attachParameters($operation, $parameters, $requestClass);
                }
            }
        }
    }

    /**
     * @param Operation $operation
     * @param class-string $trait
     *
     * @return class-string|null
     */
    private function getFormRequest(Operation $operation, string $trait): ?string
    {
        if (!in_array($operation->_context->method, self::ALLOWED_METHODS, true)) {
            return null;
        }

        foreach ($operation->_context->uses as $use) {
            if (is_subclass_of($use, FormRequest::class)
                && in_array($trait, class_uses_recursive($use), true)
            ) {
                return $use;
            }
        }

        return null;
    }

    /**
     * @param Operation $operation
     * @param list<array<string, mixed>> $parametersOptions
     * @param class-string $requestClass
     *
     * @throws ReflectionException
     *
     * @return void
     */
    private function attachParameters(Operation $operation, array $parametersOptions, string $requestClass): void
    {
        $parametersOptions = $this->filterExistingParameters($operation, $parametersOptions);

        $operation->parameters = array_merge(
            $operation->parameters == Generator::UNDEFINED ? [] : $operation->parameters,
            $this->makeParameters($requestClass, $parametersOptions),
        );
    }

    /**
     * @param string $requestClass
     * @param list<array<string, mixed>> $parametersOptions
     *
     * @throws ReflectionException
     *
     * @return list<Parameter>
     */
    private function makeParameters(string $requestClass, array $parametersOptions): array
    {
        $defaultOptions = [
            'in' => 'query',
            'required' => false,
        ];

        $parameters = [];
        foreach ($parametersOptions as $options) {
            if (!array_key_exists('options', $options)) {
                continue;
            }

            if (isset($options['context']['constant'])) {
                $class = new ReflectionClass($requestClass);
                if ($context = $class->getConstant($options['context']['constant'])) {
                    $options['options']['description'] =
                        str_replace('{{context}}', implode(', ', $context), $options['options']['description']);
                }
            }

            $parameters[] = new Parameter(array_merge($defaultOptions, $options['options']));
        }

        return $parameters;
    }

    /**
     * @param Operation $operation
     * @param list<array<string, mixed>> $parametersOptions
     *
     * @return list<array<string, mixed>>
     */
    private function filterExistingParameters(Operation $operation, array $parametersOptions): array
    {
        if (!$operation->parameters || $operation->parameters == Generator::UNDEFINED) {
            return $parametersOptions;
        }

        foreach ($parametersOptions as $i => $options) {
            foreach ($operation->parameters as $parameter) {
                if ($parameter->name === $options['options']['name']) {
                    unset($parametersOptions[$i]);
                }
            }
        }

        return $parametersOptions;
    }
}
