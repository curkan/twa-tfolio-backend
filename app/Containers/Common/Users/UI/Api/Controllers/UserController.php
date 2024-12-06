<?php

declare(strict_types=1);

namespace App\Containers\Common\Users\UI\Api\Controllers;

use App\Containers\Common\Auth\UI\Api\Resources\MeResource;
use App\Ship\Parents\Controllers\ApiController;
use App\Ship\Parents\Models\User;
use Illuminate\Http\JsonResponse;

final class UserController extends ApiController
{
    /**
     * @return JsonResponse
     * @param mixed $id
     */
    public function __invoke($id): JsonResponse
    {
        $user = User::findOrFail($id);

        return $this->resourceShow(MeResource::make($user));
    }
}
