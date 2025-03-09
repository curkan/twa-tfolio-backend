<?php

declare(strict_types=1);

namespace App\Containers\Common\Grid\UI\Api\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class NodeResource extends JsonResource
{
    /**
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => (int) $this->id,
            'sort' => (int) $this->sort,
            'x' => (int) $this->x,
            'y' => $this->y,
            'w' => $this->w,
            'h' => $this->h,
            'image' => $this->when($this->image !== null, fn () => [
                'original' => $this->image->pictureOriginal,
                'md' => $this->image->pictureMd,
                'sm' => $this->image->pictureSm,
                'xs' => $this->image->pictureXs,
            ]),
            'image' => $this->when($this->video !== null, fn () => [
                'original' => $this->image->pictureOriginal,
                'md' => $this->image->pictureMd,
                'sm' => $this->image->pictureSm,
                'xs' => $this->image->pictureXs,
            ]),
        ];
    }
}
