<?php

declare(strict_types=1);

namespace App\Containers\Common\Node\UI\Api\Controllers;

use App\Containers\Common\Grid\UI\Api\Resources\NodeResource;
use App\Containers\Common\Node\UI\Api\Requests\UpdateNodeRequest;
use App\Ship\Parents\Controllers\ApiController;
use App\Ship\Parents\Models\Node;
use Illuminate\Http\JsonResponse;

final class UpdateNodeController extends ApiController
{
    /**
     * @param UpdateNodeRequest $request
     * @param mixed $id
     *
     * @return JsonResponse
     */
    public function __invoke($id, UpdateNodeRequest $request): JsonResponse
    {
        $node = Node::findOrFail($id);
        $node->update($request->validated());

        return $this->resourceCollection(NodeResource::make($node));
    }
}
