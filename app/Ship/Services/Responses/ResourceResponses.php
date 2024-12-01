<?php

declare(strict_types=1);

namespace App\Ship\Services\Responses;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

trait ResourceResponses
{
    /**
     * @param JsonResource $resource
     *
     * @return JsonResponse
     */
    public function resourceCollection(JsonResource $resource): JsonResponse
    {
        return $resource->additional(['message' => Messages::SUCCESS])->response();
    }

    /**
     * @param JsonResource $resource
     *
     * @return JsonResponse
     */
    public function resourceShow(JsonResource $resource): JsonResponse
    {
        return response_json(Messages::SUCCESS, $resource, null, Response::HTTP_OK);
    }

    /**
     * @param JsonResource $resource
     *
     * @return JsonResponse
     */
    public function resourceStored(JsonResource $resource): JsonResponse
    {
        return response_json(Messages::SUCCESS, $resource, null, Response::HTTP_CREATED);
    }

    /**
     * @param JsonResource $resource
     *
     * @return JsonResponse
     */
    public function resourceUpdated(JsonResource $resource): JsonResponse
    {
        return $resource->additional(['message' => Messages::SUCCESS])->response();
    }

    /**
     * @return JsonResponse
     */
    public function resourceDeleted(): JsonResponse
    {
        return response_json(Messages::SUCCESS, null, null, Response::HTTP_NO_CONTENT);
    }

    /**
     * @return JsonResponse
     * @param ?string $message
     */
    public function resourceOk(?string $message = null): JsonResponse
    {
        return response_json($message ?? Messages::SUCCESS, null, null, Response::HTTP_OK);
    }
}
