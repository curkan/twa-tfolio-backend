<?php

declare(strict_types=1);

namespace App\Containers\Common\Node\UI\Api\Controllers;

use App\Containers\Common\Grid\UI\Api\Resources\NodeResource;
use App\Containers\Common\Node\UI\Api\Events\NodeLiked;
use App\Ship\Parents\Controllers\ApiController;
use App\Ship\Parents\Models\Node;
use App\Ship\Parents\Models\NodeLikes;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

final class LikeNodeController extends ApiController
{
    /**
     * @param mixed $id
     *
     * @return JsonResponse
     */
    public function __invoke($id): JsonResponse
    {
        $node = Node::findOrFail($id);

        $like = NodeLikes::where('node_id', $id)->where('user_id', Auth::id())->first();

        if (null !== $like) {
            $like->delete();
        } else {
            $isNotFirstLiked = $like = NodeLikes::where('node_id', $id)->where('user_id', Auth::id())->withTrashed()->exists();

            $productLike = NodeLikes::create([
                'node_id' => $id,
                'user_id' => Auth::id(),
                'author_user_id' => $node->user->getKey(),
            ]);

            if (!$isNotFirstLiked) {
                NodeLiked::dispatch($productLike);
            }
        }

        return $this->resourceShow(NodeResource::make($node));
    }
}
