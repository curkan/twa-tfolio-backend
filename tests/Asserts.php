<?php

declare(strict_types=1);

namespace Tests;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

trait Asserts
{
    protected function assertModelAttributes(Model $model, array $attributes): void
    {
        foreach ($attributes as $attributeKey => $attributeValue) {
            if ($attributeKey == 'meta') {
                continue;
            }

            if (is_collection($model->{$attributeKey})) {
                $modelValue = $model->{$attributeKey}->toArray();
            } elseif ($model->{$attributeKey} instanceof Carbon) {
                $modelValue = $model->{$attributeKey}->format('Y-m-d H:i:s');
            } else {
                $modelValue = $model->{$attributeKey};
            }

            if ($model->{$attributeKey} instanceof Carbon) {
                $dateInRequest = Carbon::create($attributeValue);
                $diffInSeconds = abs($dateInRequest->diffInSeconds($model->{$attributeKey}));
                self::assertTrue($diffInSeconds <= 1, 'Failing assert in dates');
            } else {
                self::assertEquals($modelValue, $attributeValue, $attributeKey);
            }
        }
    }
}
