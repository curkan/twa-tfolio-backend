<?php

declare(strict_types=1);

namespace App\Containers\Common\Auth\UI\Api\Controllers;

use App\Containers\Common\Auth\UI\Api\Requests\MeUpdateRequest;
use App\Containers\Common\Auth\UI\Api\Resources\MeResource;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

final class MeUpdateController extends ApiController
{
    /**
     * @param MeUpdateRequest $request
     *
     * @return JsonResponse
     */
    public function __invoke(MeUpdateRequest $request): JsonResponse
    {
        $user = Auth::user();

        $user->update(array_filter([
            'display_name' => $request->input('displayName'),
            'biography' => $request->input('biography'),
        ]));

        return $this->resourceUpdated(MeResource::make($user));
    }
}
