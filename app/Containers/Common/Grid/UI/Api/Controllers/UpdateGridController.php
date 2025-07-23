<?php

declare(strict_types=1);

namespace App\Containers\Common\Grid\UI\Api\Controllers;

use App\Containers\Common\Grid\UI\Api\Requests\UploadGridRequest;
use App\Containers\Common\Grid\UI\Api\Resources\GridResource;
use App\Ship\Parents\Controllers\ApiController;
use App\Ship\Parents\Models\Image;
use App\Ship\Parents\Models\Node;
use Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\DB;

final class UpdateGridController extends ApiController
{
    /**
     * @param UploadGridRequest $request
     *
     * @return JsonResponse
     */
    public function __invoke(UploadGridRequest $request): JsonResponse
    {
        $nodes = collect($request->input('nodes')); /* @phpstan-ignore-line */
        $nodesIds = $nodes->pluck('id');

        $nodes = $nodes->map(function ($item) {
            $item['sort'] = str_replace('w_', '', $item['sort']);

            return $item;
        })->keyBy('id');

        $nodesFromUser = Node::query()->where('user_id', Auth::id())->whereIn('id', $nodesIds)->get();

        if ($nodesFromUser->count() !== $nodes->count()) {
            $this->authorize(false);
        }

        DB::beginTransaction();
        foreach ($nodesFromUser as $node) {
            /** @var Node $node */
            $node->update([
                'sort' => $nodes[$node->getKey()]['sort'],
                'x' => $nodes[$node->getKey()]['x'],
                'y' => $nodes[$node->getKey()]['y'],
                'w' => $nodes[$node->getKey()]['w'],
                'h' => $nodes[$node->getKey()]['h'],
            ]);
        }

        $unusedImagesIds = Node::query()->where('user_id', Auth::id())->whereNotIn('id', $nodesIds)->pluck('image_id');
        Node::query()->where('user_id', Auth::id())->whereNotIn('id', $nodesIds)->delete();
        Image::query()->where('user_id', Auth::id())->whereIn('id', $unusedImagesIds)->delete();
        DB::commit();

        $nodes = $nodesFromUser;

        return $this->resourceCollection(GridResource::make((object) [
            'user_id' => FacadesAuth::user()->getKey(),
            'nodes' => $nodes,
        ]));
    }
}
