<?php

declare(strict_types=1);

namespace App\Containers\Common\Grid\UI\Api\Controllers;

use App\Containers\Common\Grid\UI\Api\Resources\NodeResource;
use App\Ship\Parents\Controllers\ApiController;
use App\Ship\Parents\Models\Node;
use Illuminate\Http\JsonResponse;

final class GetNodeController extends ApiController
{
    /**
     * @OA\Get(
     *     path="/common/grid/{id}",
     *     summary="Get me",
     *     tags={"Common > Grid"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful"
     *     )
     * )
     *
     * @return JsonResponse
     * @param int $id
     */
    public function __invoke(int $id): JsonResponse
    {
        $node = Node::findOrFail($id);

        return $this->resourceShow(NodeResource::make($node));
    }
}
