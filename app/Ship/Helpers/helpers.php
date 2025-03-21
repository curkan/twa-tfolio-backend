<?php

declare(strict_types=1);

use App\Ship\Services\Responses\Messages;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

if (!function_exists('response_json')) {
    /**
     * @param string $message
     * @param mixed $data
     * @param mixed $errors
     * @param int $status
     * @param array $headers
     *
     * @return JsonResponse
     */
    function response_json(string $message, mixed $data, mixed $errors, int $status = 200, array $headers = []): JsonResponse
    {
        $response = [
            'message' => $message,
        ];


        if (!empty($data)) {
            $response['data'] = $data;
        }

        // if ($data instanceof JsonResource && !empty($data->additional)) {
        //     $response['data']['meta'] = $data->additional;
        // }

        if (!empty($errors)) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $status, $headers);
    }
}

if (!function_exists('per_page_normalize')) {
    /**
     * @param int|null $perPage
     *
     * @return int
     */
    function per_page_normalize(?int $perPage = null): int
    {
        return $perPage ? min($perPage, config('app.pagination_max_page_size')) : config('app.pagination_default_page_size');
    }
}

if (!function_exists('has_pagination')) {
    /**
     * @param Request|null $request
     *
     * @return bool
     */
    function has_pagination(?Request $request = null): bool
    {
        $request = $request ?: request();

        return $request->query->has('by_page')
            || (int) $request->query('per_page') > 0
            || (int) $request->query('page') > 0;
    }
}

if (!function_exists('is_collection')) {
    /**
     * @param mixed $object
     * @return bool
     */
    function is_collection(mixed $object): bool
    {
        return $object instanceof Collection;
    }
}


if (!function_exists('to_error_log')) {
    /**
     * @param mixed $entry
     *
     * @return void
     */
    function to_error_log(mixed $entry): void
    {
        $url = request()->getUri();
        if ($entry instanceof Throwable) {
            $message = "Exc: {$entry->getMessage()} on: {$url}\n {$entry->getTraceAsString()}";
            Log::error($message);
            error_log($message);

            return;
        }

        $message = 'Message: ' . $entry . "on: {$url}\n";

        Log::warning($message);
        error_log($message);
    }
}


if (!function_exists('transaction_or_throw')) {
    /**
     * @param Closure $callback
     * @param Throwable|null $exception
     * @return void
     * @throws Throwable
     */
    function transaction_or_throw(Closure $callback, ?Throwable $exception = null): void
    {
        try {
            DB::transaction($callback); /* @phpstan-ignore-line */
        } catch (Throwable $e) {
            to_error_log($e);

            throw $exception ?: new RuntimeException(Messages::ERROR_HAS_OCCURRED, 422);
        }
    }
}

if (!function_exists('is_testing')) {
    /**
     * @return bool
     */
    function is_testing(): bool
    {
        return config('app.env') === 'testing';
    }
}
