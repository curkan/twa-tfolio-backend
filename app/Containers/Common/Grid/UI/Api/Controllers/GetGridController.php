<?php

declare(strict_types=1);

namespace App\Containers\Common\Grid\UI\Api\Controllers;

use App\Containers\Common\Grid\UI\Api\Resources\GridResource;
use App\Ship\Parents\Controllers\ApiController;
use App\Ship\Parents\Models\Node;
use Illuminate\Http\JsonResponse;

final class GetGridController extends ApiController
{
    /**
     * @OA\Get(
     *     path="/common/grid",
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
        $nodes = Node::all();

        return $this->resourceCollection(GridResource::make((object) [
            'id' => 1234,
            'nodes' => $nodes,
        ]));
    }
}
