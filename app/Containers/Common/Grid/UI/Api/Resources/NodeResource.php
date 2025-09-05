<?php

declare(strict_types=1);

namespace App\Containers\Common\Grid\UI\Api\Resources;

use App\Ship\Parents\Enums\Nodes\NodeTypeEnum;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

final class NodeResource extends JsonResource
{
    /**
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        $isLiked = $this->likes()->where('user_id', Auth::id())->exists(); /* @phpstan-ignore-line */
        $isOwner = $this->user?->is(Auth::user()) ?? false;

        return [
            'id' => (int) $this->id,
            'sort' => (int) $this->sort,
            'x' => (int) $this->x,
            'y' => $this->y,
            'w' => $this->w,
            'h' => $this->h,
            'type' => $this->type,
            'video_url' => $this->when($this->type == NodeTypeEnum::Video, fn () => $this->video->videoUrl),
            'image' => $this->when($this->image !== null || $this->video !== null, function () {
                if ($this->type === NodeTypeEnum::Image) {
                    return [
                        'original' => $this->image->pictureOriginal,
                        'md' => $this->image->pictureMd,
                        'sm' => $this->image->pictureSm,
                        'xs' => $this->image->pictureXs,
                    ];
                }

                if ($this->type === NodeTypeEnum::Video) {
                    return [
                        'original' => $this->video->poster?->pictureOriginal,
                        'md' => $this->video->poster?->pictureMd,
                        'sm' => $this->video->poster?->pictureSm,
                        'xs' => $this->video->poster?->pictureXs,
                    ];
                }
            }),
            'description' => $this->description,
            'likes_count' => $this->likes()->count(), /* @phpstan-ignore-line */
            'user' => UserNodeResource::make($this->user),
            'meta' => [
                'owner' => $isOwner,
                'is_liked' => $isLiked,
            ],
        ];
    }
}
