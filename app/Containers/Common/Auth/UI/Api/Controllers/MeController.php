<?php

declare(strict_types=1);

namespace App\Containers\Common\Auth\UI\Api\Controllers;

use App\Containers\Common\Auth\UI\Api\Resources\MeResource;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

final class MeController extends ApiController
{
    /**
     * @return JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        $user = Auth::user();

        return $this->resourceShow(MeResource::make($user));
    }
}
