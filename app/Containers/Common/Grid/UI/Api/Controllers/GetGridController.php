<?php

declare(strict_types=1);

namespace App\Containers\Common\Grid\UI\Api\Controllers;

use App\Containers\Common\Grid\UI\Api\Resources\GridResource;
use App\Ship\Parents\Controllers\ApiController;
use App\Ship\Parents\Models\Node;
use App\Ship\Parents\Models\View;
use Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

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
     * @param Request $request
     */
    public function __invoke(Request $request): JsonResponse
    {
        $userId = $request->has('user_id') ? $request->input('user_id') : Auth::id();
        $nodes = Node::where('user_id', $userId)->orderBy('y')->get();

        if ($userId != Auth::id()) {
            $existsViewInFifteenMinutes = View::where('user_id', Auth::id())
                ->where('viewed_user_id', $userId)
                ->where('created_at', '>', Carbon::now()->subMinutes(15))
                ->exists();

            if (!$existsViewInFifteenMinutes) {
                View::create([
                    'user_id' => Auth::id(),
                    'viewed_user_id' => $userId,
                ]);
            }
        }

        return $this->resourceCollection(GridResource::make((object) [
            'user_id' => Auth::id(),
            'nodes' => $nodes,
        ]));
    }
}
