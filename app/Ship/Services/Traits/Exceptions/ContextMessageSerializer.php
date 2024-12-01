<?php

declare(strict_types=1);

namespace App\Ship\Services\Traits\Exceptions;

use App\Ship\Services\Common\ContextMessage;
use Illuminate\Support\Arr;

trait ContextMessageSerializer
{
    /**
     * @param ContextMessage $message
     * @return string
     */
    protected function serializeContextMessage(ContextMessage $message): string
    {
        $messageContext = [];
        foreach ($message->context() as $key => $value) {
            $messageContext[] = "{$key}={$value}";
        }

        return empty($messageContext) ? $message->message() : $message->message() . '|' . implode('$', $messageContext);
    }

    /**
     * @param string $message
     * @return ContextMessage
     */
    protected function deserializeContextMessage(string $message): ContextMessage
    {
        $message = explode('|', $message);

        $context = [];
        if (isset($message[1])) {
            $contextList = explode('$', $message[1]);
            foreach ($contextList as $item) {
                if (empty($item)) {
                    continue;
                }

                [$key, $value] = explode('=', $item);
                $context[$key] = $value;
            }
        }

        return ContextMessage::make(Arr::first($message), $context);
    }
}
