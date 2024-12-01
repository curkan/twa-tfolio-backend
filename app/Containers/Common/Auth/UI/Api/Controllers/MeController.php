<?php

declare(strict_types=1);

namespace App\Containers\Common\Auth\UI\Api\Controllers;

use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

final class MeController extends ApiController
{
    /**
     * @OA\Get(
     *     path="/common/me",
     *     summary="Get me",
     *     tags={"Common > Auth"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful"
     *     )
     * )
     *
     * @return JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        return response_json('data', [
            'id' => Auth::user()->getKey(),
        ], []);
    }
}
